/**
 * TeleTaskServiceSoap.java
 *
 * This file was auto-generated from WSDL
 * by the Apache Axis 1.3 Oct 05, 2005 (05:23:37 EDT) WSDL2Java emitter.
 */

package de.tele_task.services;

public interface TeleTaskServiceSoap extends java.rmi.Remote {
    public de.tele_task.model.Lecture[] getAllLectures() throws java.rmi.RemoteException;
    public de.tele_task.model.Lecture getLecture(int id) throws java.rmi.RemoteException;
    public de.tele_task.model.Lecture[] getLecturesBySeries(java.lang.String seriesName) throws java.rmi.RemoteException;
}
