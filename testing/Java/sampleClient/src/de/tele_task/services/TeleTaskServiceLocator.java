/**
 * TeleTaskServiceLocator.java
 *
 * This file was auto-generated from WSDL
 * by the Apache Axis 1.3 Oct 05, 2005 (05:23:37 EDT) WSDL2Java emitter.
 */

package de.tele_task.services;

public class TeleTaskServiceLocator extends org.apache.axis.client.Service implements de.tele_task.services.TeleTaskService {

    public TeleTaskServiceLocator() {
    }


    public TeleTaskServiceLocator(org.apache.axis.EngineConfiguration config) {
        super(config);
    }

    public TeleTaskServiceLocator(java.lang.String wsdlLoc, javax.xml.namespace.QName sName) throws javax.xml.rpc.ServiceException {
        super(wsdlLoc, sName);
    }

    // Use to get a proxy class for TeleTaskServiceSoap
    private java.lang.String TeleTaskServiceSoap_address = "http://localhost:8080/webp/repo/source/soap.php";

    public java.lang.String getTeleTaskServiceSoapAddress() {
        return TeleTaskServiceSoap_address;
    }

    // The WSDD service name defaults to the port name.
    private java.lang.String TeleTaskServiceSoapWSDDServiceName = "TeleTaskServiceSoap";

    public java.lang.String getTeleTaskServiceSoapWSDDServiceName() {
        return TeleTaskServiceSoapWSDDServiceName;
    }

    public void setTeleTaskServiceSoapWSDDServiceName(java.lang.String name) {
        TeleTaskServiceSoapWSDDServiceName = name;
    }

    public de.tele_task.services.TeleTaskServiceSoap getTeleTaskServiceSoap() throws javax.xml.rpc.ServiceException {
       java.net.URL endpoint;
        try {
            endpoint = new java.net.URL(TeleTaskServiceSoap_address);
        }
        catch (java.net.MalformedURLException e) {
            throw new javax.xml.rpc.ServiceException(e);
        }
        return getTeleTaskServiceSoap(endpoint);
    }

    public de.tele_task.services.TeleTaskServiceSoap getTeleTaskServiceSoap(java.net.URL portAddress) throws javax.xml.rpc.ServiceException {
        try {
            de.tele_task.services.TeleTaskServiceSoapStub _stub = new de.tele_task.services.TeleTaskServiceSoapStub(portAddress, this);
            _stub.setPortName(getTeleTaskServiceSoapWSDDServiceName());
            return _stub;
        }
        catch (org.apache.axis.AxisFault e) {
            return null;
        }
    }

    public void setTeleTaskServiceSoapEndpointAddress(java.lang.String address) {
        TeleTaskServiceSoap_address = address;
    }

    /**
     * For the given interface, get the stub implementation.
     * If this service has no port for the given interface,
     * then ServiceException is thrown.
     */
    public java.rmi.Remote getPort(Class serviceEndpointInterface) throws javax.xml.rpc.ServiceException {
        try {
            if (de.tele_task.services.TeleTaskServiceSoap.class.isAssignableFrom(serviceEndpointInterface)) {
                de.tele_task.services.TeleTaskServiceSoapStub _stub = new de.tele_task.services.TeleTaskServiceSoapStub(new java.net.URL(TeleTaskServiceSoap_address), this);
                _stub.setPortName(getTeleTaskServiceSoapWSDDServiceName());
                return _stub;
            }
        }
        catch (java.lang.Throwable t) {
            throw new javax.xml.rpc.ServiceException(t);
        }
        throw new javax.xml.rpc.ServiceException("There is no stub implementation for the interface:  " + (serviceEndpointInterface == null ? "null" : serviceEndpointInterface.getName()));
    }

    /**
     * For the given interface, get the stub implementation.
     * If this service has no port for the given interface,
     * then ServiceException is thrown.
     */
    public java.rmi.Remote getPort(javax.xml.namespace.QName portName, Class serviceEndpointInterface) throws javax.xml.rpc.ServiceException {
        if (portName == null) {
            return getPort(serviceEndpointInterface);
        }
        java.lang.String inputPortName = portName.getLocalPart();
        if ("TeleTaskServiceSoap".equals(inputPortName)) {
            return getTeleTaskServiceSoap();
        }
        else  {
            java.rmi.Remote _stub = getPort(serviceEndpointInterface);
            ((org.apache.axis.client.Stub) _stub).setPortName(portName);
            return _stub;
        }
    }

    public javax.xml.namespace.QName getServiceName() {
        return new javax.xml.namespace.QName("http://tele-task.de/services/", "TeleTaskService");
    }

    private java.util.HashSet ports = null;

    public java.util.Iterator getPorts() {
        if (ports == null) {
            ports = new java.util.HashSet();
            ports.add(new javax.xml.namespace.QName("http://tele-task.de/services/", "TeleTaskServiceSoap"));
        }
        return ports.iterator();
    }

    /**
    * Set the endpoint address for the specified port name.
    */
    public void setEndpointAddress(java.lang.String portName, java.lang.String address) throws javax.xml.rpc.ServiceException {
        
if ("TeleTaskServiceSoap".equals(portName)) {
            setTeleTaskServiceSoapEndpointAddress(address);
        }
        else 
{ // Unknown Port Name
            throw new javax.xml.rpc.ServiceException(" Cannot set Endpoint Address for Unknown Port" + portName);
        }
    }

    /**
    * Set the endpoint address for the specified port name.
    */
    public void setEndpointAddress(javax.xml.namespace.QName portName, java.lang.String address) throws javax.xml.rpc.ServiceException {
        setEndpointAddress(portName.getLocalPart(), address);
    }

}
