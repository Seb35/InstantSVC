﻿//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated by a tool.
//     Runtime Version:2.0.50727.42
//
//     Changes to this file may cause incorrect behavior and will be lost if
//     the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

using System;
using System.ComponentModel;
using System.Diagnostics;
using System.Web.Services;
using System.Web.Services.Protocols;
using System.Xml.Serialization;

// 
// This source code was auto-generated by wsdl, Version=2.0.50727.42.
// 


/// <remarks/>
[System.CodeDom.Compiler.GeneratedCodeAttribute("wsdl", "2.0.50727.42")]
[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.ComponentModel.DesignerCategoryAttribute("code")]
[System.Web.Services.WebServiceBindingAttribute(Name="TeleTaskServiceSoap", Namespace="http://tele-task.de/services/")]
[System.Xml.Serialization.XmlIncludeAttribute(typeof(Item))]
public partial class TeleTaskService : Microsoft.Web.Services3.WebServicesClientProtocol {
    //System.Web.Services.Protocols.SoapHttpClientProtocol {
    
    private System.Threading.SendOrPostCallback GetAllLecturesOperationCompleted;
    
    private System.Threading.SendOrPostCallback GetLectureOperationCompleted;
    
    private System.Threading.SendOrPostCallback GetLecturesBySeriesOperationCompleted;
    
    /// <remarks/>
    public TeleTaskService() {
        this.Url = "http://localhost:2222/webp/repo/source/soap.php";
    }
    
    /// <remarks/>
    public event GetAllLecturesCompletedEventHandler GetAllLecturesCompleted;
    
    /// <remarks/>
    public event GetLectureCompletedEventHandler GetLectureCompleted;
    
    /// <remarks/>
    public event GetLecturesBySeriesCompletedEventHandler GetLecturesBySeriesCompleted;
    
    /// <remarks/>
    [System.Web.Services.Protocols.SoapDocumentMethodAttribute("http://tele-task.de/services/GetAllLectures", RequestNamespace="http://tele-task.de/services/", ResponseNamespace="http://tele-task.de/services/", Use=System.Web.Services.Description.SoapBindingUse.Literal, ParameterStyle=System.Web.Services.Protocols.SoapParameterStyle.Wrapped)]
    [return: System.Xml.Serialization.XmlArrayItemAttribute(Namespace="http://tele-task.de/model/")]
    public Lecture[] GetAllLectures() {
        object[] results = this.Invoke("GetAllLectures", new object[0]);
        return ((Lecture[])(results[0]));
    }
    
    /// <remarks/>
    public System.IAsyncResult BeginGetAllLectures(System.AsyncCallback callback, object asyncState) {
        return this.BeginInvoke("GetAllLectures", new object[0], callback, asyncState);
    }
    
    /// <remarks/>
    public Lecture[] EndGetAllLectures(System.IAsyncResult asyncResult) {
        object[] results = this.EndInvoke(asyncResult);
        return ((Lecture[])(results[0]));
    }
    
    /// <remarks/>
    public void GetAllLecturesAsync() {
        this.GetAllLecturesAsync(null);
    }
    
    /// <remarks/>
    public void GetAllLecturesAsync(object userState) {
        if ((this.GetAllLecturesOperationCompleted == null)) {
            this.GetAllLecturesOperationCompleted = new System.Threading.SendOrPostCallback(this.OnGetAllLecturesOperationCompleted);
        }
        this.InvokeAsync("GetAllLectures", new object[0], this.GetAllLecturesOperationCompleted, userState);
    }
    
    private void OnGetAllLecturesOperationCompleted(object arg) {
        if ((this.GetAllLecturesCompleted != null)) {
            System.Web.Services.Protocols.InvokeCompletedEventArgs invokeArgs = ((System.Web.Services.Protocols.InvokeCompletedEventArgs)(arg));
            this.GetAllLecturesCompleted(this, new GetAllLecturesCompletedEventArgs(invokeArgs.Results, invokeArgs.Error, invokeArgs.Cancelled, invokeArgs.UserState));
        }
    }
    
    /// <remarks/>
    [System.Web.Services.Protocols.SoapDocumentMethodAttribute("http://tele-task.de/services/GetLecture", RequestNamespace="http://tele-task.de/services/", ResponseNamespace="http://tele-task.de/services/", Use=System.Web.Services.Description.SoapBindingUse.Literal, ParameterStyle=System.Web.Services.Protocols.SoapParameterStyle.Wrapped)]
    [return: System.Xml.Serialization.XmlElementAttribute("Lecture")]
    public Lecture GetLecture(int id) {
        object[] results = this.Invoke("GetLecture", new object[] {
                    id});
        return ((Lecture)(results[0]));
    }
    
    /// <remarks/>
    public System.IAsyncResult BeginGetLecture(int id, System.AsyncCallback callback, object asyncState) {
        return this.BeginInvoke("GetLecture", new object[] {
                    id}, callback, asyncState);
    }
    
    /// <remarks/>
    public Lecture EndGetLecture(System.IAsyncResult asyncResult) {
        object[] results = this.EndInvoke(asyncResult);
        return ((Lecture)(results[0]));
    }
    
    /// <remarks/>
    public void GetLectureAsync(int id) {
        this.GetLectureAsync(id, null);
    }
    
    /// <remarks/>
    public void GetLectureAsync(int id, object userState) {
        if ((this.GetLectureOperationCompleted == null)) {
            this.GetLectureOperationCompleted = new System.Threading.SendOrPostCallback(this.OnGetLectureOperationCompleted);
        }
        this.InvokeAsync("GetLecture", new object[] {
                    id}, this.GetLectureOperationCompleted, userState);
    }
    
    private void OnGetLectureOperationCompleted(object arg) {
        if ((this.GetLectureCompleted != null)) {
            System.Web.Services.Protocols.InvokeCompletedEventArgs invokeArgs = ((System.Web.Services.Protocols.InvokeCompletedEventArgs)(arg));
            this.GetLectureCompleted(this, new GetLectureCompletedEventArgs(invokeArgs.Results, invokeArgs.Error, invokeArgs.Cancelled, invokeArgs.UserState));
        }
    }
    
    /// <remarks/>
    [System.Web.Services.Protocols.SoapDocumentMethodAttribute("http://tele-task.de/services/GetLecturesBySeries", RequestNamespace="http://tele-task.de/services/", ResponseNamespace="http://tele-task.de/services/", Use=System.Web.Services.Description.SoapBindingUse.Literal, ParameterStyle=System.Web.Services.Protocols.SoapParameterStyle.Wrapped)]
    [return: System.Xml.Serialization.XmlArrayItemAttribute(Namespace="http://tele-task.de/model/")]
    public Lecture[] GetLecturesBySeries(string seriesName) {
        object[] results = this.Invoke("GetLecturesBySeries", new object[] {
                    seriesName});
        return ((Lecture[])(results[0]));
    }
    
    /// <remarks/>
    public System.IAsyncResult BeginGetLecturesBySeries(string seriesName, System.AsyncCallback callback, object asyncState) {
        return this.BeginInvoke("GetLecturesBySeries", new object[] {
                    seriesName}, callback, asyncState);
    }
    
    /// <remarks/>
    public Lecture[] EndGetLecturesBySeries(System.IAsyncResult asyncResult) {
        object[] results = this.EndInvoke(asyncResult);
        return ((Lecture[])(results[0]));
    }
    
    /// <remarks/>
    public void GetLecturesBySeriesAsync(string seriesName) {
        this.GetLecturesBySeriesAsync(seriesName, null);
    }
    
    /// <remarks/>
    public void GetLecturesBySeriesAsync(string seriesName, object userState) {
        if ((this.GetLecturesBySeriesOperationCompleted == null)) {
            this.GetLecturesBySeriesOperationCompleted = new System.Threading.SendOrPostCallback(this.OnGetLecturesBySeriesOperationCompleted);
        }
        this.InvokeAsync("GetLecturesBySeries", new object[] {
                    seriesName}, this.GetLecturesBySeriesOperationCompleted, userState);
    }
    
    private void OnGetLecturesBySeriesOperationCompleted(object arg) {
        if ((this.GetLecturesBySeriesCompleted != null)) {
            System.Web.Services.Protocols.InvokeCompletedEventArgs invokeArgs = ((System.Web.Services.Protocols.InvokeCompletedEventArgs)(arg));
            this.GetLecturesBySeriesCompleted(this, new GetLecturesBySeriesCompletedEventArgs(invokeArgs.Results, invokeArgs.Error, invokeArgs.Cancelled, invokeArgs.UserState));
        }
    }
    
    /// <remarks/>
    public new void CancelAsync(object userState) {
        base.CancelAsync(userState);
    }
}

/// <remarks/>
[System.CodeDom.Compiler.GeneratedCodeAttribute("wsdl", "2.0.50727.42")]
[System.SerializableAttribute()]
[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.ComponentModel.DesignerCategoryAttribute("code")]
[System.Xml.Serialization.XmlTypeAttribute(Namespace="http://tele-task.de/model/")]
public partial class Lecture : Item {
    
    private int idField;
    
    private string nameField;
    
    private int durationField;
    
    private bool durationFieldSpecified;
    
    private string namehtmlField;
    
    private string streamurldslField;
    
    private string abstractField;
    
    private System.Nullable<int> languagesIdField;
    
    private bool languagesIdFieldSpecified;
    
    private System.Nullable<int> logoField;
    
    private bool logoFieldSpecified;
    
    private System.Nullable<int> timeField;
    
    private bool timeFieldSpecified;
    
    private string sortdateField;
    
    /// <remarks/>
    public int id {
        get {
            return this.idField;
        }
        set {
            this.idField = value;
        }
    }
    
    /// <remarks/>
    public string name {
        get {
            return this.nameField;
        }
        set {
            this.nameField = value;
        }
    }
    
    /// <remarks/>
    public int duration {
        get {
            return this.durationField;
        }
        set {
            this.durationField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlIgnoreAttribute()]
    public bool durationSpecified {
        get {
            return this.durationFieldSpecified;
        }
        set {
            this.durationFieldSpecified = value;
        }
    }
    
    /// <remarks/>
    public string namehtml {
        get {
            return this.namehtmlField;
        }
        set {
            this.namehtmlField = value;
        }
    }
    
    /// <remarks/>
    public string streamurldsl {
        get {
            return this.streamurldslField;
        }
        set {
            this.streamurldslField = value;
        }
    }
    
    /// <remarks/>
    public string @abstract {
        get {
            return this.abstractField;
        }
        set {
            this.abstractField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(IsNullable=true)]
    public System.Nullable<int> languagesId {
        get {
            return this.languagesIdField;
        }
        set {
            this.languagesIdField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlIgnoreAttribute()]
    public bool languagesIdSpecified {
        get {
            return this.languagesIdFieldSpecified;
        }
        set {
            this.languagesIdFieldSpecified = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(IsNullable=true)]
    public System.Nullable<int> logo {
        get {
            return this.logoField;
        }
        set {
            this.logoField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlIgnoreAttribute()]
    public bool logoSpecified {
        get {
            return this.logoFieldSpecified;
        }
        set {
            this.logoFieldSpecified = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlElementAttribute(IsNullable=true)]
    public System.Nullable<int> time {
        get {
            return this.timeField;
        }
        set {
            this.timeField = value;
        }
    }
    
    /// <remarks/>
    [System.Xml.Serialization.XmlIgnoreAttribute()]
    public bool timeSpecified {
        get {
            return this.timeFieldSpecified;
        }
        set {
            this.timeFieldSpecified = value;
        }
    }
    
    /// <remarks/>
    public string sortdate {
        get {
            return this.sortdateField;
        }
        set {
            this.sortdateField = value;
        }
    }
}

/// <remarks/>
[System.Xml.Serialization.XmlIncludeAttribute(typeof(Lecture))]
[System.CodeDom.Compiler.GeneratedCodeAttribute("wsdl", "2.0.50727.42")]
[System.SerializableAttribute()]
[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.ComponentModel.DesignerCategoryAttribute("code")]
[System.Xml.Serialization.XmlTypeAttribute(Namespace="http://tele-task.de/model/")]
public partial class Item {
}

/// <remarks/>
[System.CodeDom.Compiler.GeneratedCodeAttribute("wsdl", "2.0.50727.42")]
public delegate void GetAllLecturesCompletedEventHandler(object sender, GetAllLecturesCompletedEventArgs e);

/// <remarks/>
[System.CodeDom.Compiler.GeneratedCodeAttribute("wsdl", "2.0.50727.42")]
[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.ComponentModel.DesignerCategoryAttribute("code")]
public partial class GetAllLecturesCompletedEventArgs : System.ComponentModel.AsyncCompletedEventArgs {
    
    private object[] results;
    
    internal GetAllLecturesCompletedEventArgs(object[] results, System.Exception exception, bool cancelled, object userState) : 
            base(exception, cancelled, userState) {
        this.results = results;
    }
    
    /// <remarks/>
    public Lecture[] Result {
        get {
            this.RaiseExceptionIfNecessary();
            return ((Lecture[])(this.results[0]));
        }
    }
}

/// <remarks/>
[System.CodeDom.Compiler.GeneratedCodeAttribute("wsdl", "2.0.50727.42")]
public delegate void GetLectureCompletedEventHandler(object sender, GetLectureCompletedEventArgs e);

/// <remarks/>
[System.CodeDom.Compiler.GeneratedCodeAttribute("wsdl", "2.0.50727.42")]
[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.ComponentModel.DesignerCategoryAttribute("code")]
public partial class GetLectureCompletedEventArgs : System.ComponentModel.AsyncCompletedEventArgs {
    
    private object[] results;
    
    internal GetLectureCompletedEventArgs(object[] results, System.Exception exception, bool cancelled, object userState) : 
            base(exception, cancelled, userState) {
        this.results = results;
    }
    
    /// <remarks/>
    public Lecture Result {
        get {
            this.RaiseExceptionIfNecessary();
            return ((Lecture)(this.results[0]));
        }
    }
}

/// <remarks/>
[System.CodeDom.Compiler.GeneratedCodeAttribute("wsdl", "2.0.50727.42")]
public delegate void GetLecturesBySeriesCompletedEventHandler(object sender, GetLecturesBySeriesCompletedEventArgs e);

/// <remarks/>
[System.CodeDom.Compiler.GeneratedCodeAttribute("wsdl", "2.0.50727.42")]
[System.Diagnostics.DebuggerStepThroughAttribute()]
[System.ComponentModel.DesignerCategoryAttribute("code")]
public partial class GetLecturesBySeriesCompletedEventArgs : System.ComponentModel.AsyncCompletedEventArgs {
    
    private object[] results;
    
    internal GetLecturesBySeriesCompletedEventArgs(object[] results, System.Exception exception, bool cancelled, object userState) : 
            base(exception, cancelled, userState) {
        this.results = results;
    }
    
    /// <remarks/>
    public Lecture[] Result {
        get {
            this.RaiseExceptionIfNecessary();
            return ((Lecture[])(this.results[0]));
        }
    }
}
