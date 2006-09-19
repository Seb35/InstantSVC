/**
 * QueryLecturePortType.java
 *
 * This file was auto-generated from WSDL
 * by the Apache Axis 1.3 Oct 05, 2005 (05:23:37 EDT) WSDL2Java emitter.
 */

package org.example.queryLecture;

public interface QueryLecturePortType extends java.rmi.Remote {
    public org.example.queryLecture.Lecture[] getAllLectures() throws java.rmi.RemoteException;
    public org.example.queryLecture.Lecture getLecture(int id) throws java.rmi.RemoteException;
    public void updateOrAddLecture(org.example.queryLecture.Lecture lecture) throws java.rmi.RemoteException;
    public java.lang.String[] getIdAndNameOfAllLectures() throws java.rmi.RemoteException;
    public java.lang.String getLectureNameById(int id) throws java.rmi.RemoteException;
    public java.lang.String[] getAbstractbyName(java.lang.String[] name) throws java.rmi.RemoteException;
    public void updateLectureNameById(int id, java.lang.String name) throws java.rmi.RemoteException;
    public org.example.queryLecture.Lecture[] getLecturesByLecturegroups(java.lang.String lecturegroupName) throws java.rmi.RemoteException;
    public org.example.queryLecture.Lecture[] getLecturesByAuthor(java.lang.String authorName) throws java.rmi.RemoteException;
    public org.example.queryLecture.Lecture[] getLecturesBySpeaker(java.lang.String speakerName) throws java.rmi.RemoteException;
    public org.example.queryLecture.Lecture[] getLecturesByLanguage(java.lang.String language) throws java.rmi.RemoteException;
    public void flushItems() throws java.rmi.RemoteException;
    public void deleteItem(int id) throws java.rmi.RemoteException;
}
