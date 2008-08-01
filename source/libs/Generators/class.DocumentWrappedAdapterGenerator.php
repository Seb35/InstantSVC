<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** DocumentWrappedAdapterGenerator                                       **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @author     Falko Menge <mail@falko-menge.de>                         **
//** @copyright  2006 ...                                                  **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once dirname(__FILE__).'/../../../libs/reflection/class.ExtReflectionClass.php';
require_once dirname(__FILE__).'/../../../libs/reflection/class.ExtReflectionMethod.php';
require_once dirname(__FILE__).'/../../../libs/misc/class.file.php';

//***** DocumentWrappedAdapterGenerator *************************************
/**
 * generates adapter classes for document-literal Web Services.
 *
 * The generated classes will make the unwrapping arguments and the
 * wrapping of return values.
 *
 * @example
 * <code>
 *   require_once 'class.MyClass.php';
 *   require_once 'class.DocumentWrappedAdapterGenerator.php';
 *   $myDocumentWrappedAdapterGenerator = new DocumentWrappedAdapterGenerator('MyClass', NULL, 'MyClassDocumentWrappedAdapter');
 *   $adapterClassFile = $myDocumentWrappedAdapterGenerator->saveToFile('./', 'class.MyClassDocumentWrappedAdapter.php');
 *
 *   require_once $adapterClassFile;
 *   $server = new SoapServer('./service.wsdl');
 *   $server->setClass('MyClassDocumentWrappedAdapter');
 *   $server->handle();
 * </code>
 *
 * @example
 * <code>
 *   require_once 'class.MyClass.php';
 *   require_once 'class.DocumentWrappedAdapterGenerator.php';
 *   $myDocumentWrappedAdapterGenerator = new DocumentWrappedAdapterGenerator('MyClass');
 *   eval($myDocumentWrappedAdapterGenerator->getAdapterClass());
 *
 *   $server = new SoapServer('./service.wsdl');
 *   $server->setClass($myDocumentWrappedAdapterGenerator->getAdapterClassName());
 *   $server->handle();
 * </code>
 *
 * @package    libs.generator
 * @author     Falko Menge <mail@falko-menge.de>
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
 */
class DocumentWrappedAdapterGenerator {

    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $classFile;

    /**
     * @var string
     */
    private $adapterClassName;

    /**
     * @var string
     */
    private $adapterClass;

    //=======================================================================
    /**
     * generates adapter classes for document-literal Web Services.
     *
     * @param string $className name of the class
     * @param ExtReflectionMethod[] $methods array of ExtReflectionMethod objects
     * @param string $adapterClassName name of the generated class
     */
    public function __construct($className, $methods = NULL, $adapterClassName = '') {
        if (empty($className)) {
            throw new Exeption('Argument className was empty.');
        } else {
            $this->className = $className;
        }

        if (!class_exists($className)) {
            throw new Exception('Class not found '.$className);
        }

        $myExtReflectionClass = new ExtReflectionClass($this->className);

        $this->classFile = $myExtReflectionClass->getFileName();

        if ($methods == NULL) {
            $methods = $myExtReflectionClass->getMethods();
        }
        if (empty($adapterClassName)) {
            $this->adapterClassName = $this->generateAdapterClassName($this->className);
        } else {
            $this->adapterClassName = $adapterClassName;
        }
        $gen = '/**' . "\n";
        $gen.= ' * auto-generated document-wrapped adapter class for class `' . $this->className . "'\n";
        $gen.= ' *' . "\n";
        $gen.= ' * The class will make the unwrapping arguments and the' . "\n";
        $gen.= ' * wrapping of return values.' . "\n";
        $gen.= ' *' . "\n";
        $gen.= ' * generated by DocumentWrappedAdapterGenerator' . "\n";
        $gen.= ' */' . "\n";
        $gen.= 'class ' . $this->adapterClassName . ' {' . "\n";
        $gen.= '' . "\n";
        $gen.= '    /**' . "\n";
        $gen.= '     * @var '  . $this->className . "\n";
        $gen.= '     */' . "\n";
        $gen.= '    private $target;' . "\n";
        $gen.= '' . "\n";
        $gen.= '    /**' . "\n";
        $gen.= '     * @param '  . $this->className . ' $target' . "\n";
        $gen.= '     */' . "\n";
        $gen.= '    public function __construct($target = null) {' . "\n";
        $gen.= '        if (empty($target)) {' . "\n";
        
        $gen.= '			//May be we have a singleton class, just check for some common names' . "\n";
        $gen.= '			if (is_callable(array(\''.$this->className.'\', \'__construct\'), false)) {' . "\n";
	    $gen.= '		       $obj = new '.$this->className.'();' . "\n";
        $gen.= '		    }' . "\n";
        $gen.= '			elseif (is_callable(array(\''.$this->className.'\', \'getInstance\'), false)) {' . "\n";
	    $gen.= '			   $obj = call_user_func(array(\''.$this->className.'\', \'getInstance\'));' . "\n";
        $gen.= '		    }' . "\n";
        $gen.= '		    elseif (is_callable(array(\''.$this->className.'\', \'getSingleton\'), false)) {' . "\n";
	    $gen.= '		       $obj = call_user_func(array(\''.$this->className.'\', \'getSingleton\'));' . "\n";
        $gen.= '		    }' . "\n";
        $gen.= '            $this->target = $obj;' . "\n";
        $gen.= '        } else {' . "\n";
        $gen.= '            $this->target = $target;' . "\n";
        $gen.= '        }' . "\n";
        $gen.= '    }' . "\n";
        $gen.= '' . "\n";
        foreach ($methods as $method) {
            if (!$method->isConstructor() and !$method->isDestructor() and !$method->isMagic()) {
                $methodName = $method->getName();
                $params = $method->getParameters();
                $returnType = $method->getReturnType();

                //echo $methodName . "<br>\n";
                $gen.= '    /**' . "\n";
                $gen.= '     * @param object $args' . "\n";
                if (!empty($returnType)) {
                    $gen.= '     * @return array<string,' . $returnType->toString() . '>' . "\n";
                } else {
                    $gen.= '     * @return array<string,mixed>' . "\n";
                }
                $gen.= '     */' . "\n";
                $gen.= '    public function ' . $methodName . '(';
                if (!empty($params)) {
                    $gen.= '$args';
                }
                $gen.= ') {' . "\n";

                // TODO: decide which naming convention to use (has to be compatible with WSDLGenerator)
                $returnElementName = $methodName . 'Result';
                //$returnElementName = 'return';

                $gen.= '        return array(\'' . $returnElementName . '\' => $this->target->' . $methodName . '(';
                if (!empty($params)) {
                    foreach ($params as $param) {
                        $gen.= '$args->' . $param->getName() . ', ';
                    }
                    $gen = substr($gen, 0, -2); //remove last ', '
                }
                $gen.= '));' . "\n";
                $gen.= '    }' . "\n";
                $gen.= '' . "\n";
            }
        }
        $gen.= '}';
        $this->adapterClass = $gen;
    }

    //=======================================================================
    /**
     * returns the generated php code for the adapter class
     *
     * @return string generated php code for the adapter class
     */
    public function getAdapterClass() {
        return $this->adapterClass;
    }

    //=======================================================================
    /**
     * returns name of the generated adapter class
     *
     * @return string name of the generated adapter class
     */
    public function getAdapterClassName() {
        return $this->adapterClassName;
    }

    //=======================================================================
    /**
     * writes the generated php code for the adapter class into a file
     *
     * @param string $outputFolder folder for the generated php file
     * @param string $fileName name for the generated php file
     * @param boolean $requireDependingClass if true add a require statement
     * @return string path to generated file
     */
    public function saveToFile($outputFolder, $fileName = '', $requireDependingClass = true) {
        if (empty($fileName)) {
            $fileName = $this->generateClassFileName($this->adapterClassName);
        }
        $path = $outputFolder . '/' . $fileName;

        if ($requireDependingClass) {
            $file = File::absolutePathToRelativePath($outputFolder, $this->classFile);
            $req = 'require_once(\''.$file.'\');'."\n\n";
        }
        else {
            $req = '';
        }

        file_put_contents($path, "<?php\n" .$req. $this->adapterClass . "\n?>\n");
        return $path;
    }

    //=======================================================================
    /**
     * generates a name for an adapter class based on the name of the original class
     *
     * @param string $classname name of the original class
     * @return string filename for an adapter class
     */
    public static function generateAdapterClassName($classname) {
        return $classname . 'DocumentWrappedAdapter';
    }

    //=======================================================================
    /**
     * generates a filename for a class based on the name of the class
     *
     * @param string $classname name of a class
     * @return string filename for the class
     */
    public static function generateClassFileName($classname) {
        return 'class.' . $classname . '.php';
    }
}
