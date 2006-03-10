/**
 * TeleTaskService.java
 *
 * This file was auto-generated from WSDL
 * by the Apache Axis 1.3 Oct 05, 2005 (05:23:37 EDT) WSDL2Java emitter.
 */

package de.tele_task.services;

public interface TeleTaskService extends javax.xml.rpc.Service {
    public java.lang.String getTeleTaskServiceSoapAddress();

    public de.tele_task.services.TeleTaskServiceSoap getTeleTaskServiceSoap() throws javax.xml.rpc.ServiceException;

    public de.tele_task.services.TeleTaskServiceSoap getTeleTaskServiceSoap(java.net.URL portAddress) throws javax.xml.rpc.ServiceException;
}
