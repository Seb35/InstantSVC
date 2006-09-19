/**
 * QueryLectureLocator.java
 *
 * This file was auto-generated from WSDL
 * by the Apache Axis 1.3 Oct 05, 2005 (05:23:37 EDT) WSDL2Java emitter.
 */

package org.example.queryLecture;

public class QueryLectureLocator extends org.apache.axis.client.Service implements org.example.queryLecture.QueryLecture {

    public QueryLectureLocator() {
    }


    public QueryLectureLocator(org.apache.axis.EngineConfiguration config) {
        super(config);
    }

    public QueryLectureLocator(java.lang.String wsdlLoc, javax.xml.namespace.QName sName) throws javax.xml.rpc.ServiceException {
        super(wsdlLoc, sName);
    }

    // Use to get a proxy class for queryLecturePort
    private java.lang.String queryLecturePort_address = "http://example.org/queryLecture";

    public java.lang.String getqueryLecturePortAddress() {
        return queryLecturePort_address;
    }

    // The WSDD service name defaults to the port name.
    private java.lang.String queryLecturePortWSDDServiceName = "queryLecturePort";

    public java.lang.String getqueryLecturePortWSDDServiceName() {
        return queryLecturePortWSDDServiceName;
    }

    public void setqueryLecturePortWSDDServiceName(java.lang.String name) {
        queryLecturePortWSDDServiceName = name;
    }

    public org.example.queryLecture.QueryLecturePortType getqueryLecturePort() throws javax.xml.rpc.ServiceException {
       java.net.URL endpoint;
        try {
            endpoint = new java.net.URL(queryLecturePort_address);
        }
        catch (java.net.MalformedURLException e) {
            throw new javax.xml.rpc.ServiceException(e);
        }
        return getqueryLecturePort(endpoint);
    }

    public org.example.queryLecture.QueryLecturePortType getqueryLecturePort(java.net.URL portAddress) throws javax.xml.rpc.ServiceException {
        try {
            org.example.queryLecture.QueryLectureBindingStub _stub = new org.example.queryLecture.QueryLectureBindingStub(portAddress, this);
            _stub.setPortName(getqueryLecturePortWSDDServiceName());
            return _stub;
        }
        catch (org.apache.axis.AxisFault e) {
            return null;
        }
    }

    public void setqueryLecturePortEndpointAddress(java.lang.String address) {
        queryLecturePort_address = address;
    }

    /**
     * For the given interface, get the stub implementation.
     * If this service has no port for the given interface,
     * then ServiceException is thrown.
     */
    public java.rmi.Remote getPort(Class serviceEndpointInterface) throws javax.xml.rpc.ServiceException {
        try {
            if (org.example.queryLecture.QueryLecturePortType.class.isAssignableFrom(serviceEndpointInterface)) {
                org.example.queryLecture.QueryLectureBindingStub _stub = new org.example.queryLecture.QueryLectureBindingStub(new java.net.URL(queryLecturePort_address), this);
                _stub.setPortName(getqueryLecturePortWSDDServiceName());
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
        if ("queryLecturePort".equals(inputPortName)) {
            return getqueryLecturePort();
        }
        else  {
            java.rmi.Remote _stub = getPort(serviceEndpointInterface);
            ((org.apache.axis.client.Stub) _stub).setPortName(portName);
            return _stub;
        }
    }

    public javax.xml.namespace.QName getServiceName() {
        return new javax.xml.namespace.QName("http://example.org/queryLecture", "queryLecture");
    }

    private java.util.HashSet ports = null;

    public java.util.Iterator getPorts() {
        if (ports == null) {
            ports = new java.util.HashSet();
            ports.add(new javax.xml.namespace.QName("http://example.org/queryLecture", "queryLecturePort"));
        }
        return ports.iterator();
    }

    /**
    * Set the endpoint address for the specified port name.
    */
    public void setEndpointAddress(java.lang.String portName, java.lang.String address) throws javax.xml.rpc.ServiceException {
        
if ("queryLecturePort".equals(portName)) {
            setqueryLecturePortEndpointAddress(address);
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
