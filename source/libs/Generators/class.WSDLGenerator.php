<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** WSDLGenerator                                                         **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    WSDLGenerator                                             **
//** @author     Gregor Gabrysiak <gregor_abrak at web dot de>             **
//** @author     Falko Menge <mail@falko-menge.de>                         **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2005-2006 ...                                             **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

require_once dirname(__FILE__).'/../../../libs/reflection/class.ExtReflectionClass.php';

//***** WSDLGenerator *******************************************************
/**
 * @package    libs.generator
 * @author     Gregor Gabrysiak <gregor_abrak at web dot de>
 * @author     Falko Menge <mail@falko-menge.de>
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class WSDLGenerator
{
	const DOCUMENT_WRAPPED = 0;
    const RPC_LITERAL = 1;
    const RPC_ENCODED = 2;

    /**
     * @var string
     */
    private $classname;
    /**
     * @var string
     */
    private $serviceName;
    /**
     * @var string
     */
    private $serviceAccessPointURL;
    /**
     * @var string
     */
    private $namespace;
    /**
     * @var string
     */
    private $typeNamespace;
    /**
     * @var string[]
     */
    private $myFunctionNames;
    /**
     * @var array<string,string>
     */
    private $documentationForMethods;
    /**
     * @var string[]
     */
    private $myComplexTypes;
    /**
     * @var boolean
     */
    private $treeFinished;
    /**
     * @var string
     */
    private $bindingStyle;
    /**
     * @var string
     */
    private $bindingUse;
    /**
     * @var DOMDocument
     */
    private $dom;
    /**
     * @var DOMElement
     */
    private $definitions;
    /**
     * @var DOMElement
     */
    private $types;
    /**
     * @var DOMElement
     */
    private $schema;
    /**
     * @var DOMElement
     */
    private $portType;
    /**
     * @var DOMElement
     */
    private $binding;
    /**
     * @var DOMElement
     */
    private $service;

    //==========================================================================
    /**
     * The Constructor stores the necessary parameters into global attributes.
     *
     * @param string $serviceName
     * @param string $serviceAccessPointURL
     * @param string $namespace
     * @param int $soapBinding
     * @return void
     */
    public function __construct(
        $serviceName,
        $serviceAccessPointURL,
        $namespace,
        $soapBinding = WSDLGenerator::DOCUMENT_WRAPPED)
    {
        // to avoid invalid arguments
        if (empty($serviceName))
        { throw new Exception('First argument was empty.'); }
        if (empty($serviceAccessPointURL))
        { throw new Exception('Second argument was empty.'); }
        if (empty($namespace))
        { throw new Exception('Third argument was empty.'); }

        // to make parameters globally available
        $this->serviceName = $serviceName;
        $this->$serviceAccessPointURL = $serviceAccessPointURL;
        $this->namespace = $namespace;

        // default DOCUMENT LITERAL WRAPPED
        $this->bindingStyle = 'document';
        $this->bindingUse = 'literal';

        if (($soapBinding == 1) or ($soapBinding == WSDLGenerator::RPC_LITERAL))
        {
            $this->bindingStyle = 'rpc';
            $this->bindingUse = 'literal';
        }
        elseif (($soapBinding == 2) or ($soapBinding == WSDLGenerator::RPC_ENCODED))
        {
            $this->bindingStyle = 'rpc';
            $this->bindingUse = 'encoded';
        }
        // signals the generator, that finishTree() still has to be called
        $this->treeFinished = false;
    }

    //==========================================================================
    /**
     * This function is used to set up the DOM-Tree and to make the important
     * nodes accessible by assigning global variables to them. Furthermore,
     * depending on the used "USE", diferent namespaces are added to the
     * definition element.
     * Important: the nodes are not appended now, because the messages are not
     * created yet. That's why they are appended after the messages are created.
     *
     * @return void
     */
    protected function generateTree()
    {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $this->dom->formatOutput = true;
        $this->definitions = $this->dom->createElement('definitions','');
        $this->definitions->setAttribute('name', $this->serviceName);
        $this->definitions->setAttribute('targetNamespace', $this->namespace);
        $this->definitions->setAttribute('xmlns', 'http://schemas.xmlsoap.org/wsdl/');
        $this->definitions->setAttribute('xmlns:tns', $this->namespace);
        $this->definitions->setAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        if ($this->bindingUse == 'encoded')
        {
            $this->definitions->setAttribute('xmlns:soapenc', 'http://schemas.xmlsoap.org/soap/encoding/');
        }
        if (empty($this->typeNamespace))
        {
            $this->typeNamespace = $this->namespace;
        }
        $this->definitions->setAttribute('xmlns:types', $this->typeNamespace);
        $this->definitions->setAttribute('xmlns:soap', 'http://schemas.xmlsoap.org/wsdl/soap/');
        $this->definitions->setAttribute('xmlns:wsdl', 'http://schemas.xmlsoap.org/wsdl/');
        $this->definitions = $this->dom->appendChild($this->definitions);

        // Type-Section
        $this->types = $this->dom->createElement('types','');
        $this->types = $this->definitions->appendChild($this->types);
        $this->schema = $this->dom->createElement('schema','');
        $this->schema->setAttribute('xmlns', 'http://www.w3.org/2001/XMLSchema');
        $this->schema->setAttribute('targetNamespace', $this->typeNamespace);
        $this->schema->setAttribute('xmlns:tns', $this->typeNamespace);
        $this->schema->setAttribute('elementFormDefault', 'qualified');
        if ($this->bindingUse == 'encoded')
        {
            $this->schema->setAttribute('xmlns:soapenc', 'http://schemas.xmlsoap.org/soap/encoding/');
        }
        $this->schema = $this->types->appendChild($this->schema);

        // PortType-Section
        $this->portType = $this->dom->createElement('portType','');
        $this->portType->setAttribute('name', $this->serviceName.'PortType');

        // Binding-Section
        $this->binding = $this->dom->createElement('binding','');
        $this->binding->setAttribute('name',$this->serviceName.'Binding');
        $this->binding->setAttribute('type','tns:'.$this->serviceName.'PortType');
        $soap = $this->dom->createElement('soap:binding','');
        $soap->setAttribute('transport','http://schemas.xmlsoap.org/soap/http');
        $soap->setAttribute('style',$this->bindingStyle);
        $soap = $this->binding->appendChild($soap);

        // Service-Section
        $this->service = $this->dom->createElement('service','');
        $this->service->setAttribute('name',$this->serviceName);
    }

    //==========================================================================
    /**
     * This method is useful to get the order of the DOMNodes like they should
     * be. That means, that we wait till all the message elements are finished,
     * then we insert the other DOMNodes.
     *
     * @return void
     */
    protected function finishTree()
    {
        if ($this->treeFinished == false)
        {

            $this->portType = $this->definitions->appendChild($this->portType);
            $this->binding = $this->definitions->appendChild($this->binding);
            $this->service = $this->definitions->appendChild($this->service);
            $this->treeFinished = true;
        }
    }

    //==========================================================================
    /**
     * This function is used to start the generation of a WSDL-file for the
     * class whose name is given.
     *
     * It is not intended to use a class as well as
     * a set of functions for the WSDL-file. Therefore, as soon as at least one
     * function was added by addFunction(), this method will throw an exception.
     * addFunction and setClass exclude eachother!
     *
     * If it is used with $usePolicyPlugIn = true, the class PolicyPlugIn has to
     * be loaded, it's not included by this generator.
     *
     * If the user added comments to the methods, these are retrieved and added
     * later in the portType element.
     *
     * @param string $classname
     * @param boolean $usePolicyPlugIn enables the plug in which filters the methods
     * @return boolean
     */
    public function setClass($classname, $usePolicyPlugIn = false)
    {
        // check if addFunction was used before
        if (empty($this->myFunctionNames))
        {
            if (empty($this->dom))
            {
                // set up DOM-Tree
                $this->generateTree();
            }
            $this->classname = $classname;
            $this->myComplexTypes[] = null;

            // retrieving information about the methods of the class
            $myExtReflectionClass = new ExtReflectionClass($classname);
            $myMethods = $myExtReflectionClass->getMethods();

            if ($usePolicyPlugIn) {
                $plugin = new PolicyPlugIn();
                $myMethods = $plugin->getPublishedMethods($myMethods);
                $this->documentationForMethods = $plugin->getUserComments($myMethods);
            }

            foreach($myMethods as $method)
            {
                $this->addOperation($method);
            }

            // create SERVICE section
            $this->generateService();
            return true;
        }
        else
        {
            throw new Exception('It\'s not possible to create a SOAP server'.
            ' with a set of functions and a class.\nTry to unite all the'.
            ' functions you need in one class. Afterwards, use that class'.
            ' to create a WSDL file.');
        }
    }

    //==========================================================================
    /**
     * This method enables the use of a seperate namespace for the schema. This
     * namespace has to be set before setClass() or addFunction() were called.
     * If no seperate namespace is used, the same namespace is used for the
     * whole document.
     *
     * @param string $typeNamespace
     * @return void
     */
    public function setTypeNamespace($typeNamespace)
    {
        if ((empty($this->classname)) and (empty($this->myFunctionNames)))
        {
            $this->typeNamespace = $typeNamespace;
        }
        else
        {
                throw new Exception('The namespace for types may only be'.
                    ' set before adding a function or setting a class.');
        }
    }

    //==========================================================================
    /**
     * The generation of the WSDL-file is step by step for each function. That's
     * why it is possible to pass a set of functions step by step to this
     * method as well.
     * As soon as a class was added to the WSDL, no function can be added.
     * addFunction and setClass exclude eachother!
     *
     * @param string $functionName
     * @return boolean
     */
    public function addFunction($functionName)
    {
        // check if function was already added
        if (!(in_array($functionName ,$this->myFunctionNames)))
        {
            if (empty($this->classname))
            {
                if (empty($this->dom))
                {
                    // set up DOM-Tree
                    $this->generateTree();
                }

                $myExtReflectionFunction = new ExtReflectionFunction($functionName);

                if ($this->addOperation($myExtReflectionFunction))
                {
                    // save functionName in array to be able to decide,
                    // whether a function is already added or not
                    $this->myFunctionNames[] = $functionName;
                    return true;
                }
                else
                {
                    throw new Exception('addFunction( '. $functionName .
                        ') failed.');
                }
            }
            else
            {
                throw new Exception('A class is already used to create a'.
                    ' WSDL-file. The creation works only for ONE class OR'.
                    ' a set of functions.');
            }
        }
    }

    //==========================================================================
    /**
     * This method processes methods passed to it by addFunction() and
     * setClass(). Depending on Style and Use, different methods are called to
     * handle the creation of suitable elements for the WSDL file.
     * The method returns TRUE if the processing was successful, otherwise,
     * FALSE is returned.
     *
     * @param ExtReflectionMethod $method
     * @return boolean
     */
    protected function addOperation($method)
    {
        if (!($method->isMagic()) && ($method->getName() !='getInstance'))
        {
            if ($this->bindingStyle != 'rpc')
            {
                // using Document Literal Wrapped
                if ($this->generateMessageDocLit($method) == false)
                {
                    return false;
                }
            }
            else
            {
                // same for RPC ENCODED and LITERAL
                if ($this->generateMessageRPC($method) == false)
                {
                    return false;
                }

            }
            $this->generatePorttypeOperation($method);
            $this->generateBinding($method);
        }
        return true;
    }

    //==========================================================================
    /**
     * This method generates two messages for each function - one for the
     * request, send from client to Web Server, and for the response, which
     * is sent from the Web Server to theclient who invoked the function.
     * Like the name says, the method is used for RPC/LITERAL and ENCODED.
     *
     * @param ExtReflectionMethod $method
     * @return boolean
     */
    protected function generateMessageRPC($method)
    {
        // request
        $message = $this->dom->createElement('message', '');
        $message->setAttribute('name', $method->getName()); // name of method

        $params = $method->getParameters();
        if (!empty($params))
        {
            foreach ($params as $param) // list of input
            {
                $paramType = $param->getType();
                if (!empty($paramType))
                {
                    $part = $this->dom->createElement('part', '');
                    $part->setAttribute('name', $param->getName()); // name of Parameter
                    if ($this->bindingUse == 'literal')
                    {
                        $part->setAttribute('type', $this->generateLiteralSchema($paramType));
                    }
                    elseif ($this->bindingUse == 'encoded')
                    {
                        $part->setAttribute('type',$this->generateEncodedSchema($paramType));
                    }
                    $part = $message->appendChild($part);
                }
                else
                {
                    trigger_error('The type of parameter '.$param->getName().' of method '.$method->getName().' is not documented.'.
                        'For this method, no WSDL operation will be generated.',E_USER_WARNING);
                    return false;
                }
            }
        }
        $message = $this->definitions->appendChild($message);

        // response
        $message = $this->dom->createElement('message','');
        $message->setAttribute('name',$method->getName().'Response'); // name of method
        $message = $this->definitions->appendChild($message);
        $returnType = $method->getReturnType();
        if (!(empty($returnType)) and ($returnType->toString() != 'void'))
        {
            $part = $this->dom->createElement('part','');
            $part->setAttribute('name','return');
            if ($this->bindingUse == 'encoded')
            {
                $part->setAttribute('type',$this->generateEncodedSchema($returnType));
            }
            elseif ($this->bindingUse == 'literal')
            {
                $part->setAttribute('type', $this->generateLiteralSchema($returnType));
            }
            $part = $message->appendChild($part);
        }
        return true;
    }

    //==========================================================================
    /**
     * A schema is generated for the type given. It is possible, that this
     * method needs to be called recursively to create schema for more complex
     * types inside the given type (e.g. a class with complex properties).
     * As a side-effect, it returns the converted type's name which has to be
     * used in the WSDL-file as "type" of the given parameter.
     * This method generates schemas for RPC/ENCODED.
     *
     * @param ExtReflectionType $type
     * @return void
     */
    protected function generateEncodedSchema($type)
    {// mapping
        $returnValue = "string";
        if ($type->isClass())
        {
            // checks, if the generated WSDL already contains a schema for
            // that class
            if (!(in_array($type->toString().'class' ,$this->myComplexTypes)))
            {
                $complexType = $this->dom->createElement('complexType','');
                $complexType->setAttribute('name', $type->getName());
                $complexType = $this->schema->appendChild($complexType);

                $sequence = $this->dom->createElement('sequence','');
                $sequence = $complexType->appendChild($sequence);

                $myNewProperties = $type->getProperties();

                // recursively for each property
                foreach($myNewProperties as $prop)
                {
                    $propType = $prop->getType();

                    $element = $this->dom->createElement('element','');
                    $element->setAttribute('name', $prop->getName());
                    // TODO: decide if nillable has to be set
                    /*if ($prop->isPrimitive())
                    {
                        $element->setAttribute('nillable','true');
                    }//*/
                    $element->setAttribute('type',$this->generateEncodedSchema($propType));
                    $element = $sequence->appendChild($element);
                }
                $this->myComplexTypes[] = $type->toString().'class';
            }

            //reference to own typesection and use complexType-element
            $returnValue = 'types:'.$type->toString();
        }
        elseif ($type->isArray())
        {
            $arrayType = $type->getArrayType();
            $arrayTypeName = $arrayType->getXMLName();
            $complexTypeName = 'ArrayOf' . $arrayType->toString();

            // checks, if the generated WSDL already contains a schema for
            // that array
            if (!(in_array($complexTypeName, $this->myComplexTypes)))
            {
                $complexType = $this->dom->createElement('complexType','');
                $complexType->setAttribute('name', $complexTypeName);
                $complexType = $this->schema->appendChild($complexType);

                $complexContent = $this->dom->createElement('complexContent','');
                $complexContent = $complexType->appendChild($complexContent);

                $restriction = $this->dom->createElement('restriction','');
                $restriction->setAttribute('base','soapenc:Array');
                $restriction = $complexContent->appendChild($restriction);

                $attribute = $this->dom->createElement('attribute','');
                $attribute->setAttribute('ref','soapenc:arrayType');
                $attribute->setAttribute('wsdl:arrayType',$this->generateEncodedSchema($arrayType));
                $attribute = $restriction->appendChild($attribute);
                $this->myComplexTypes[] = $complexTypeName;
            }

            $returnValue = 'types:' . $complexTypeName;
        }

        elseif ($type->isMap())
        {
            // we need an item [IndexType,ValueType]
            // and an array of that item min=0 max=unbounded type= (item)
            $indexType = $type->getMapIndexType();
            $valueType = $type->getMapValueType();
            $convertedIndexType = $this->generateLiteralSchema($indexType);
            $convertedValueType = $this->generateLiteralSchema($valueType);
            if (!(in_array($indexType->toString().$valueType->toString().'map',$this->myComplexTypes)))
            {
                if (!(in_array($indexType->toString().$valueType->toString().'item',$this->myComplexTypes)))
                {   // create item: sequence of Index and Value of map

                    $complexType = $this->dom->createElement('complexType','');
                    $complexType->setAttribute('name', $indexType->toString().$valueType->toString().'item');
                    $complexType = $this->schema->appendChild($complexType);
                    $sequence = $this->dom->createElement('sequence','');
                    $sequence = $complexType->appendChild($sequence);
                    // INDEXTYPE
                    $indexElement = $this->dom->createElement('element','');
                    $indexElement->setAttribute('name', 'index');
                    $indexElement->setAttribute('type', $convertedIndexType);
                    $indexElement = $sequence->appendChild($indexElement);
                    // VALUETYPE
                    $valueElement = $this->dom->createElement('element','');
                    $valueElement->setAttribute('name', 'value');
                    $valueElement->setAttribute('type', $convertedValueType);
                    $valueElement = $sequence->appendChild($valueElement);
                    $this->myComplexTypes[] = $indexType->toString().$valueType->toString().'item';
                }

                $complexType = $this->dom->createElement('complexType','');
                // name e.g. "ArrayOfInteger"
                $complexType->setAttribute('name', 'ArrayOf' . ucfirst($arrayType->toString()));
                $complexType = $this->schema->appendChild($complexType);

                $complexContent = $this->dom->createElement('complexContent','');
                $complexContent = $complexType->appendChild($complexContent);

                $restriction = $this->dom->createElement('restriction','');
                $restriction->setAttribute('base','soapenc:Array');
                $restriction = $complexContent->appendChild($restriction);

                $attribute= $this->dom->createElement('attribute','');
                $attribute->setAttribute('ref','soapenc:arrayType');
                $attribute->setAttribute('wsdl:arrayType',$this->generateEncodedSchema($arrayType));
                $attribute = $restriction->appendChild($attribute);
                $this->myComplexTypes[] = $arrayType->toString().'array';
                $complexType = $this->dom->createElement('complexType','');
                // Name of Map: e.g. integerstringmap
                $complexType->setAttribute('name', $indexType->toString().$valueType->toString().'map');
                $complexType = $this->schema->appendChild($complexType);

                $sequence = $this->dom->createElement('sequence','');
                $sequence = $complexType->appendChild($sequence);

                if ($arrayType->isPrimitive()) {$arrayTypeInXML = $arrayType->getXMLName();}
                else  {$arrayTypeInXML = $this->generateLiteralSchema($arrayType);}
                $element->setAttribute('name', $indexType->toString().$valueType->toString().'array');
                $element->setAttribute('type', $indexType->toString().$valueType->toString().'item');

                // add an entry into the array to avoid another schema
                // generation for the same type
                $this->myComplexTypes[] = $indexType->toString().$valueType->toString().'map';
            }

            $returnValue = 'types:'.$indexType.$valueType.'map';

        }
        elseif ($type->isPrimitive())
        { // TODO: 'types:(primitive)' ?
            switch ($type->toString())
            {
                case ('integer'):
                    $returnValue = 'int';
                    break;
                case ('string'):
                    $returnValue = 'string';
                    break;
                case ('float'):
                    $returnValue = 'float';
                    break;
                case ('boolean'):
                    $returnValue = 'boolean';
                    break;
                default: $returnValue = 'string';
            }
            // TODO: decide which mode is correct:
            // - $returnValue = 'xsd:' . $returnValue;
            //    needed for passing test cases in soap_interop/Round2/Base
            //      OR
            // - $returnValue = 'soapenc:' . $returnValue;
            //    which is in our opinion the correct version
            //
            // meanwhile:
            // this leaves it to the SOAP client/server to use the right encoding
            // => test cases 23 and 24 in soap_interop/Round2/Base will FAIL
            $returnValue = '' . $returnValue;
        }

        return $returnValue;
    }

    //==========================================================================
    /**
     * A schema is generated for the type given. It is possible, that this
     * method needs to be called recursively to create schema for more complex
     * types inside the given type (e.g. a class with complex properties).
     * As a side-effect, it returns the converted type's name which has to be
     * used in the WSDL-file as "type" of the given parameter.
     * This method generates schemas for RPC/ENCODED.
     *
     * @param ExtReflectionType $type
     * @return void
     */
    protected function generateLiteralSchema($type)
    {// mapping

        $name = $type->getXMLName();
        $returnValue = "xsd:string";

        if ($type->isClass())
        {
            // checks, if the generated WSDL already contains a schema for
            // that class
            if (!(in_array($name,$this->myComplexTypes)))
            {
                $myNewProperties = $type->getProperties();
                if (!empty($myNewProperties))
                {
                    foreach($myNewProperties as $prop)
                    {
                        $propType = $prop->getType();
                        if (($propType->isClass()) or ($propType->isArray()) or ($propType->isMap()))
                        {
                            // create recursively all the schemas needed for the
                            // classes which are properties in classes we need
                            // add as schemas
                            $this->generateLiteralSchema($propType);
                        }
                    }
                }
                $complexTypeAndContent = $type->getXmlSchema($this->dom);
                $complexTypeAndContent = $this->schema->appendChild($complexTypeAndContent);
                $this->myComplexTypes[] = $name;
            }
            //reference to own typesection and use complexType-element
            $returnValue = 'types:'.$name;
        }
        elseif ($type->isArray())
        {
            $arrayType = $type->getArrayType();
            $complexTypeName = 'ArrayOf' . $arrayType->toString();

            // checks, if the generated WSDL already contains a schema for
            // that array
            if (!in_array($complexTypeName, $this->myComplexTypes))
            {
                $complexType = $this->dom->createElement('complexType','');
                $complexType->setAttribute('name', $complexTypeName); // Name of Array
                $complexType = $this->schema->appendChild($complexType);

                $sequence = $this->dom->createElement('sequence','');
                $sequence = $complexType->appendChild($sequence);

                $element = $this->dom->createElement('element','');
                $element->setAttribute('minOccurs', '0');
                $element->setAttribute('maxOccurs', 'unbounded');

                // now: checking, if the arrayType passed down is a Primitive
                // if not: create the XML-Schema in the same Namespace
                if ($arrayType->isPrimitive()) {$arrayTypeInXML = $arrayType->getXMLName();}
                else  {$arrayTypeInXML = $this->generateLiteralSchema($arrayType);}
                $element->setAttribute('name', $arrayType->toString());
                $element->setAttribute('type', $arrayTypeInXML);
                $element = $sequence->appendChild($element);

                $this->myComplexTypes[] = $complexTypeName;
            }
            $returnValue = 'types:' . $complexTypeName;
        }
        elseif ($type->isMap())
        {
            // we need a item [IndexType,ValueType]
            // and an array of that item min=0 max=unbounded type= (item)
            $indexType = $type->getMapIndexType();
            $valueType = $type->getMapValueType();
            $convertedIndexType = $this->generateLiteralSchema($indexType);
            $convertedValueType = $this->generateLiteralSchema($valueType);
            if (!(in_array($indexType->toString().$valueType->toString().'map',$this->myComplexTypes)))
            {
                if (!(in_array($indexType->toString().$valueType->toString().'item',$this->myComplexTypes)))
                {   // create item: sequence of Index and Value of map

                    $complexType = $this->dom->createElement('complexType','');
                    $complexType->setAttribute('name', $indexType->toString().$valueType->toString().'item');
                    $complexType = $this->schema->appendChild($complexType);
                    $sequence = $this->dom->createElement('sequence','');
                    $sequence = $complexType->appendChild($sequence);
                    // INDEXTYPE
                    $indexElement = $this->dom->createElement('element','');
                    $indexElement->setAttribute('minOccurs', '1');
                    $indexElement->setAttribute('maxOccurs', '1');
                    $indexElement->setAttribute('name', 'index');
                    $indexElement->setAttribute('type', $convertedIndexType);
                    $indexElement = $sequence->appendChild($indexElement);
                    // VALUETYPE
                    $valueElement = $this->dom->createElement('element','');
                    $valueElement->setAttribute('minOccurs', '1');
                    $valueElement->setAttribute('maxOccurs', '1');
                    $valueElement->setAttribute('name', 'value');
                    $valueElement->setAttribute('type', $convertedValueType);
                    $valueElement = $sequence->appendChild($valueElement);
                    $this->myComplexTypes[] = $indexType->toString().$valueType->toString().'item';
                }
                $complexType = $this->dom->createElement('complexType','');
                // Name of Map: e.g. integerstringmap
                $complexType->setAttribute('name', $indexType->toString().$valueType->toString().'map');
                $complexType = $this->schema->appendChild($complexType);

                $sequence = $this->dom->createElement('sequence','');
                $sequence = $complexType->appendChild($sequence);

                $element = $this->dom->createElement('element','');
                $element->setAttribute('minOccurs', '0');
                $element->setAttribute('maxOccurs', 'unbounded');

                if ($arrayType->isPrimitive()) {$arrayTypeInXML = $arrayType->getXMLName();}
                else  {$arrayTypeInXML = $this->generateLiteralSchema($arrayType);}
                $element->setAttribute('name', $indexType->toString().$valueType->toString().'array');
                $element->setAttribute('type', $indexType->toString().$valueType->toString().'item');

                $this->myComplexTypes[] = $indexType->toString().$valueType->toString().'map';
            }

            $returnValue = 'types:'.$indexType->toString().$valueType->toString().'map';

        }
        elseif ($type->isPrimitive())
        {
            $returnValue = $type->getXMLName();
        }
        return $returnValue;
    }

    //==========================================================================
    /**
     * This method is used for creating the necessary request schema inside the
     * complexType element for the request message parameter list.
     * It's used for Document Literal Wrapped
     *
     * @param ExtReflectionMethod $method
     * @return void
     */
    protected function generateComplexTypeRequestDocLitW($method)
    {
        $element = $this->dom->createElement('element', '');

        // NAME OF METHOD for Request
        $element->setAttribute('name', $method->getName());
        $element = $this->schema->appendChild($element);
        $complexType = $this->dom->createElement('complexType', '');
        $complexType = $element->appendChild($complexType);

        $params = $method->getParameters();
        if (!empty($params))
        {
            $sequence = $this->dom->createElement('sequence', '');
            $sequence = $complexType->appendChild($sequence);

            foreach ($params as $param)
            {
                $paramType = $param->getType();
                if (!empty($paramType))
                {
                    $element = $this->dom->createElement('element', '');
                    $element->setAttribute('name', $param->getName());
                    // TODO: $element->setAttribute('nillable', 'true');

                    if ($param->isOptional())
                    {
                        $element->setAttribute('minOccurs', '0');
                        $element->setAttribute('maxOccurs', '1');
                    }

                    // type of Parameter, even for classes
                    $element->setAttribute('type', $this->generateLiteralSchema($paramType));
                    $element = $sequence->appendChild($element);
                }
                else
                {
                    trigger_error('The type of parameter '.$param->getName().
                        ' of method '.$method->getName().' is not documented.'.
                        ' For this method, no WSDL operation will be generated.',
                        E_USER_WARNING);
                    return false;
                }
            }
        }

        return true;
    }

    //==========================================================================
    /**
     * The method is used for creating the necessary response schema inside the
     * complexType element for the response message parameter list.
     * Returns TRUE if successful.
     *
     * @param ExtReflectionMethod $method
     * @return void
     */
    protected function generateComplexTypeResponseDocLitW($method)
    {
        $element = $this->dom->createElement('element','');
        $element->setAttribute('name', $method->getName() . 'Response');
        $element = $this->schema->appendChild($element);
        $complexType = $this->dom->createElement('complexType','');
        $complexType = $element->appendChild($complexType);
        $returnType = $method->getReturnType();
        if (!empty($returnType) and !($returnType->toString() == 'void'))
        {
            $sequence = $this->dom->createElement('sequence','');
            $sequence = $complexType->appendChild($sequence);
            $element = $this->dom->createElement('element','');

            // TODO: decide which naming convention to use (has to be
            // compatible with DocumentWrappedAdapterGenerator)
            $element->setAttribute('name', $method->getName() . 'Result');  // more human readable and used by DocumentWrappedAdapterGenerator
            //$element->setAttribute('name', 'return');  // used in original test cases of soap_interop/Round4/GroupI

            $element->setAttribute('minOccurs','1');
            $element->setAttribute('maxOccurs','1');

            // type of Parameter, also for classes
            $element->setAttribute('type',$this->generateLiteralSchema($returnType));
            $element = $sequence->appendChild($element);
        }

        return true;
    }

    //==========================================================================
    /**
     * This function generates two messages for each function - one for the
     * request, send from client to Web Server and also the response, which
     * is sent from Web Server to the client who invoked the function.
     * The messages are used to define the parameters, which have to be
     * exchanged, their type and their order.
     * This function is used for DOCUMENT LITERAL WRAPPED.
     *
     * @param ExtReflectionMethod $method
     * @return return boolean
     */
    protected function generateMessageDocLit($method)
    {
        // request
        $message = $this->dom->createElement('message','');

        // name of method Request
        $message->setAttribute('name',$method->getName().'In');
        $message = $this->definitions->appendChild($message);
        $part = $this->dom->createElement('part','');
        $part->setAttribute('name','parameters');
        $part->setAttribute('element','types:'.$method->getName());
        $message->appendChild($part);
        if ($this->generateComplexTypeRequestDocLitW($method) == false)
        {
            return false;
        }

        // response
        $message = $this->dom->createElement('message','');

        // name of method RESPONSE
        $message->setAttribute('name',$method->getName().'Out');
        $message = $this->definitions->appendChild($message);
        $part = $this->dom->createElement('part', '');
        $part->setAttribute('name', 'parameters');

        //Look for Schema in TNS
        $part->setAttribute('element', 'types:' . $method->getName() . 'Response');
        $part = $message->appendChild($part);
        if ($this->generateComplexTypeResponseDocLitW($method) == false)
        {
            return false;
        }

        return true;
    }

    //==========================================================================
    /**
     * For each method, an operation has to be added inside the PortType-element.
     * The comments retrieved by the policyPlugIn are added as documentation. If
     * If the policyPlugIn is not used, the documentation is empty, but should
     * be completed nevertheless by editing the WSDL-file by yourself.
     * This method is invoked for encoded ans literal as well.
     *
     * @param ExtReflectionMethod $method
     * @return void
     */
    protected function generatePorttypeOperation($method)
    {
        $methodName = $method->getName();

        if (isset($this->documentationForMethods[$methodName])) {
            $documentation = $this->dom->createElement('documentation','');
            $documentationText = $this->documentationForMethods[$methodName];
            $documentationTextNode = $this->dom->createTextNode($documentationText);
            $documentationTextNode = $documentation->appendChild($documentationTextNode);
            $documentation = $this->portType->appendChild($documentation);
        }

        $operation = $this->dom->createElement('operation','');
        // default is DOCUMENT LITERAL
        $operationName = $methodName;
        $inputMessage  = 'tns:'.$operationName.'In';
        $outputMessage = 'tns:'.$operationName.'Out';

        // but if RPC is used:
        if ($this->bindingStyle == 'rpc')
        {
            $inputMessage  = 'tns:'.$operationName;
            $outputMessage = 'tns:'.$operationName.'Response';
        }
        $operation->setAttribute('name', $operationName);
        $operation = $this->portType->appendChild($operation);

        $input  = $this->dom->createElement('input','');
        $input->setAttribute('message',$inputMessage);
        $input = $operation->appendChild($input);

        $output = $this->dom->createElement('output','');
        $output->setAttribute('message',$outputMessage);
        $output = $operation->appendChild($output);
    }

    //==========================================================================
    /**
     * The binding is generated. This includes the bindingStyle and the
     * bindingUse.
     *
     * @param ExtendedReflectionMethodObject $method
     * @return void
     */
    protected function generateBinding($method)
    {
        $operation = $this->dom->createElement('operation','');
        $operation->setAttribute('name',$method->getName());
        $operation = $this->binding->appendChild($operation);

        $soap = $this->dom->createElement('soap:operation','');
        $soap->setAttribute('soapAction',$method->getName());
        $soap = $operation->appendChild($soap);

        $input = $this->dom->createElement('input','');
        $input = $operation->appendChild($input);

        $soapin = $this->dom->createElement('soap:body','');
        $soapin->setAttribute('namespace',$this->namespace);
        $soapin->setAttribute('soapAction',$this->namespace);
        $soapin->setAttribute('use',$this->bindingUse);
        if ($this->bindingUse == 'encoded')
        {
            $soapin->setAttribute('encodingStyle','http://schemas.xmlsoap.org/soap/encoding/');
        }
        $soapin = $input->appendChild($soapin);

        $output = $this->dom->createElement('output','');
        $output = $operation->appendChild($output);
        $soapout = $this->dom->createElement('soap:body','');

        $soapout->setAttribute('namespace',$this->namespace);
        $soapout->setAttribute('use',$this->bindingUse);
        if ($this->bindingUse == 'encoded')
        {
            $soapout->setAttribute('encodingStyle','http://schemas.xmlsoap.org/soap/encoding/');
        }
        $soapout = $output->appendChild($soapout);
    }

    //==========================================================================
    /**
     * The method generates the serviceelement for the WSDL-file in which the
     * port is bound to the appropriate binding.
     *
     * @return void
     */
    protected function generateService()
    {
        $port = $this->dom->createElement('port','');
        $port->setAttribute('name',$this->serviceName.'Port'); //portname
        $port->setAttribute('binding','tns:'.$this->serviceName.'Binding'); //binding
        $port = $this->service->appendChild($port);

        $soap = $this->dom->createElement('soap:address','');
        $soap->setAttribute('location',$this->namespace);
        $soap = $port->appendChild($soap);
    }

    //==========================================================================
    /**
     * Returns the DOM-Tree for further use by the user.
     * If necessary, the DOM-Tree is finished before (all nodes are finally
     * appended).
     *
     * @return DOMDocument
     */
    public function getDOMDocument()
    {
        $this->finishTree();
        return $this->dom;
    }

    //==========================================================================
    /**
     * Returns the DOM-Tree converted into a string.
     * If necessary, the DOM-Tree is finished before (all nodes are finally
     * appended).
     *
     * @return string
     */
    public function getString()
    {
        $this->finishTree();
        return $this->dom->saveXML();
    }

    //==========================================================================
    /**
     * Saves the content of the WSDL to the given filename.
     * If necessary, the DOM-Tree is finished before (all nodes are finally
     * appended).
     * Returns TRUE if saving was successful, FALSE otherwise.
     *
     * @param string $filename
     * @return boolean
     */
    public function saveToFile($filename)
    {
        $this->finishTree();
        if ($this->dom->save($filename) === false)
            return false;
        else

            return true;

        // TODO: decide if to use ONLY
        // --->  return $this->dom->save($filename);
        // which returns the number of bits written or FALSE
    }

    //==========================================================================
    /**
     * The WSDL-content is saved by calling the method saveToFile() and
     * afterwards, the saved file is used to start the SOAP server to handle
     * requests.
     * This method should be used for development purposes only.
     *
     * @param string $filename
     * @return void
     */
    public function saveToFileAndStartSOAPServer($filename)
    {
        if ($this->saveToFile($filename)) //if (save > 0) if other implementation is used
        {
            try {
                // disable WSDL cache for development
                // ini_set('soap.wsdl_cache_enabled', 0);
                $server = new SOAPServer($filename);
                $server->setClass($this->classname);
                $server->handle();
            }
            catch (SOAPFault $f) {
                print $f->faultstring;
            }
        }
        else
        {
            throw new Exception('Saving the WSDL failed. Please check the'
                . 'directory and name before trying it again.');
        }
    }
}
?>
