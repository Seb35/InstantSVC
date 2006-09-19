/**
 * Lecture.java
 *
 * This file was auto-generated from WSDL
 * by the Apache Axis 1.3 Oct 05, 2005 (05:23:37 EDT) WSDL2Java emitter.
 */

package org.example.queryLecture;

public class Lecture  implements java.io.Serializable {
    private java.lang.Integer id;

    private java.lang.String name;

    private java.lang.String duration;

    private java.lang.String namehtml;

    private java.lang.String streamurldsl;

    private java.lang.String streamurlisdn;

    private java.lang.String streamurllivestream;

    private java.lang.String _abstract;

    private java.lang.Integer languagesId;

    private java.lang.Integer logo;

    private java.lang.String time;

    private java.lang.String sortdate;

    private java.lang.String livestreamstarttime;

    private java.lang.String livestreamendtime;

    private java.lang.String place;

    private java.lang.Integer institution;

    public Lecture() {
    }

    public Lecture(
           java.lang.Integer id,
           java.lang.String name,
           java.lang.String duration,
           java.lang.String namehtml,
           java.lang.String streamurldsl,
           java.lang.String streamurlisdn,
           java.lang.String streamurllivestream,
           java.lang.String _abstract,
           java.lang.Integer languagesId,
           java.lang.Integer logo,
           java.lang.String time,
           java.lang.String sortdate,
           java.lang.String livestreamstarttime,
           java.lang.String livestreamendtime,
           java.lang.String place,
           java.lang.Integer institution) {
           this.id = id;
           this.name = name;
           this.duration = duration;
           this.namehtml = namehtml;
           this.streamurldsl = streamurldsl;
           this.streamurlisdn = streamurlisdn;
           this.streamurllivestream = streamurllivestream;
           this._abstract = _abstract;
           this.languagesId = languagesId;
           this.logo = logo;
           this.time = time;
           this.sortdate = sortdate;
           this.livestreamstarttime = livestreamstarttime;
           this.livestreamendtime = livestreamendtime;
           this.place = place;
           this.institution = institution;
    }


    /**
     * Gets the id value for this Lecture.
     * 
     * @return id
     */
    public java.lang.Integer getId() {
        return id;
    }


    /**
     * Sets the id value for this Lecture.
     * 
     * @param id
     */
    public void setId(java.lang.Integer id) {
        this.id = id;
    }


    /**
     * Gets the name value for this Lecture.
     * 
     * @return name
     */
    public java.lang.String getName() {
        return name;
    }


    /**
     * Sets the name value for this Lecture.
     * 
     * @param name
     */
    public void setName(java.lang.String name) {
        this.name = name;
    }


    /**
     * Gets the duration value for this Lecture.
     * 
     * @return duration
     */
    public java.lang.String getDuration() {
        return duration;
    }


    /**
     * Sets the duration value for this Lecture.
     * 
     * @param duration
     */
    public void setDuration(java.lang.String duration) {
        this.duration = duration;
    }


    /**
     * Gets the namehtml value for this Lecture.
     * 
     * @return namehtml
     */
    public java.lang.String getNamehtml() {
        return namehtml;
    }


    /**
     * Sets the namehtml value for this Lecture.
     * 
     * @param namehtml
     */
    public void setNamehtml(java.lang.String namehtml) {
        this.namehtml = namehtml;
    }


    /**
     * Gets the streamurldsl value for this Lecture.
     * 
     * @return streamurldsl
     */
    public java.lang.String getStreamurldsl() {
        return streamurldsl;
    }


    /**
     * Sets the streamurldsl value for this Lecture.
     * 
     * @param streamurldsl
     */
    public void setStreamurldsl(java.lang.String streamurldsl) {
        this.streamurldsl = streamurldsl;
    }


    /**
     * Gets the streamurlisdn value for this Lecture.
     * 
     * @return streamurlisdn
     */
    public java.lang.String getStreamurlisdn() {
        return streamurlisdn;
    }


    /**
     * Sets the streamurlisdn value for this Lecture.
     * 
     * @param streamurlisdn
     */
    public void setStreamurlisdn(java.lang.String streamurlisdn) {
        this.streamurlisdn = streamurlisdn;
    }


    /**
     * Gets the streamurllivestream value for this Lecture.
     * 
     * @return streamurllivestream
     */
    public java.lang.String getStreamurllivestream() {
        return streamurllivestream;
    }


    /**
     * Sets the streamurllivestream value for this Lecture.
     * 
     * @param streamurllivestream
     */
    public void setStreamurllivestream(java.lang.String streamurllivestream) {
        this.streamurllivestream = streamurllivestream;
    }


    /**
     * Gets the _abstract value for this Lecture.
     * 
     * @return _abstract
     */
    public java.lang.String get_abstract() {
        return _abstract;
    }


    /**
     * Sets the _abstract value for this Lecture.
     * 
     * @param _abstract
     */
    public void set_abstract(java.lang.String _abstract) {
        this._abstract = _abstract;
    }


    /**
     * Gets the languagesId value for this Lecture.
     * 
     * @return languagesId
     */
    public java.lang.Integer getLanguagesId() {
        return languagesId;
    }


    /**
     * Sets the languagesId value for this Lecture.
     * 
     * @param languagesId
     */
    public void setLanguagesId(java.lang.Integer languagesId) {
        this.languagesId = languagesId;
    }


    /**
     * Gets the logo value for this Lecture.
     * 
     * @return logo
     */
    public java.lang.Integer getLogo() {
        return logo;
    }


    /**
     * Sets the logo value for this Lecture.
     * 
     * @param logo
     */
    public void setLogo(java.lang.Integer logo) {
        this.logo = logo;
    }


    /**
     * Gets the time value for this Lecture.
     * 
     * @return time
     */
    public java.lang.String getTime() {
        return time;
    }


    /**
     * Sets the time value for this Lecture.
     * 
     * @param time
     */
    public void setTime(java.lang.String time) {
        this.time = time;
    }


    /**
     * Gets the sortdate value for this Lecture.
     * 
     * @return sortdate
     */
    public java.lang.String getSortdate() {
        return sortdate;
    }


    /**
     * Sets the sortdate value for this Lecture.
     * 
     * @param sortdate
     */
    public void setSortdate(java.lang.String sortdate) {
        this.sortdate = sortdate;
    }


    /**
     * Gets the livestreamstarttime value for this Lecture.
     * 
     * @return livestreamstarttime
     */
    public java.lang.String getLivestreamstarttime() {
        return livestreamstarttime;
    }


    /**
     * Sets the livestreamstarttime value for this Lecture.
     * 
     * @param livestreamstarttime
     */
    public void setLivestreamstarttime(java.lang.String livestreamstarttime) {
        this.livestreamstarttime = livestreamstarttime;
    }


    /**
     * Gets the livestreamendtime value for this Lecture.
     * 
     * @return livestreamendtime
     */
    public java.lang.String getLivestreamendtime() {
        return livestreamendtime;
    }


    /**
     * Sets the livestreamendtime value for this Lecture.
     * 
     * @param livestreamendtime
     */
    public void setLivestreamendtime(java.lang.String livestreamendtime) {
        this.livestreamendtime = livestreamendtime;
    }


    /**
     * Gets the place value for this Lecture.
     * 
     * @return place
     */
    public java.lang.String getPlace() {
        return place;
    }


    /**
     * Sets the place value for this Lecture.
     * 
     * @param place
     */
    public void setPlace(java.lang.String place) {
        this.place = place;
    }


    /**
     * Gets the institution value for this Lecture.
     * 
     * @return institution
     */
    public java.lang.Integer getInstitution() {
        return institution;
    }


    /**
     * Sets the institution value for this Lecture.
     * 
     * @param institution
     */
    public void setInstitution(java.lang.Integer institution) {
        this.institution = institution;
    }

    private java.lang.Object __equalsCalc = null;
    public synchronized boolean equals(java.lang.Object obj) {
        if (!(obj instanceof Lecture)) return false;
        Lecture other = (Lecture) obj;
        if (obj == null) return false;
        if (this == obj) return true;
        if (__equalsCalc != null) {
            return (__equalsCalc == obj);
        }
        __equalsCalc = obj;
        boolean _equals;
        _equals = true && 
            ((this.id==null && other.getId()==null) || 
             (this.id!=null &&
              this.id.equals(other.getId()))) &&
            ((this.name==null && other.getName()==null) || 
             (this.name!=null &&
              this.name.equals(other.getName()))) &&
            ((this.duration==null && other.getDuration()==null) || 
             (this.duration!=null &&
              this.duration.equals(other.getDuration()))) &&
            ((this.namehtml==null && other.getNamehtml()==null) || 
             (this.namehtml!=null &&
              this.namehtml.equals(other.getNamehtml()))) &&
            ((this.streamurldsl==null && other.getStreamurldsl()==null) || 
             (this.streamurldsl!=null &&
              this.streamurldsl.equals(other.getStreamurldsl()))) &&
            ((this.streamurlisdn==null && other.getStreamurlisdn()==null) || 
             (this.streamurlisdn!=null &&
              this.streamurlisdn.equals(other.getStreamurlisdn()))) &&
            ((this.streamurllivestream==null && other.getStreamurllivestream()==null) || 
             (this.streamurllivestream!=null &&
              this.streamurllivestream.equals(other.getStreamurllivestream()))) &&
            ((this._abstract==null && other.get_abstract()==null) || 
             (this._abstract!=null &&
              this._abstract.equals(other.get_abstract()))) &&
            ((this.languagesId==null && other.getLanguagesId()==null) || 
             (this.languagesId!=null &&
              this.languagesId.equals(other.getLanguagesId()))) &&
            ((this.logo==null && other.getLogo()==null) || 
             (this.logo!=null &&
              this.logo.equals(other.getLogo()))) &&
            ((this.time==null && other.getTime()==null) || 
             (this.time!=null &&
              this.time.equals(other.getTime()))) &&
            ((this.sortdate==null && other.getSortdate()==null) || 
             (this.sortdate!=null &&
              this.sortdate.equals(other.getSortdate()))) &&
            ((this.livestreamstarttime==null && other.getLivestreamstarttime()==null) || 
             (this.livestreamstarttime!=null &&
              this.livestreamstarttime.equals(other.getLivestreamstarttime()))) &&
            ((this.livestreamendtime==null && other.getLivestreamendtime()==null) || 
             (this.livestreamendtime!=null &&
              this.livestreamendtime.equals(other.getLivestreamendtime()))) &&
            ((this.place==null && other.getPlace()==null) || 
             (this.place!=null &&
              this.place.equals(other.getPlace()))) &&
            ((this.institution==null && other.getInstitution()==null) || 
             (this.institution!=null &&
              this.institution.equals(other.getInstitution())));
        __equalsCalc = null;
        return _equals;
    }

    private boolean __hashCodeCalc = false;
    public synchronized int hashCode() {
        if (__hashCodeCalc) {
            return 0;
        }
        __hashCodeCalc = true;
        int _hashCode = 1;
        if (getId() != null) {
            _hashCode += getId().hashCode();
        }
        if (getName() != null) {
            _hashCode += getName().hashCode();
        }
        if (getDuration() != null) {
            _hashCode += getDuration().hashCode();
        }
        if (getNamehtml() != null) {
            _hashCode += getNamehtml().hashCode();
        }
        if (getStreamurldsl() != null) {
            _hashCode += getStreamurldsl().hashCode();
        }
        if (getStreamurlisdn() != null) {
            _hashCode += getStreamurlisdn().hashCode();
        }
        if (getStreamurllivestream() != null) {
            _hashCode += getStreamurllivestream().hashCode();
        }
        if (get_abstract() != null) {
            _hashCode += get_abstract().hashCode();
        }
        if (getLanguagesId() != null) {
            _hashCode += getLanguagesId().hashCode();
        }
        if (getLogo() != null) {
            _hashCode += getLogo().hashCode();
        }
        if (getTime() != null) {
            _hashCode += getTime().hashCode();
        }
        if (getSortdate() != null) {
            _hashCode += getSortdate().hashCode();
        }
        if (getLivestreamstarttime() != null) {
            _hashCode += getLivestreamstarttime().hashCode();
        }
        if (getLivestreamendtime() != null) {
            _hashCode += getLivestreamendtime().hashCode();
        }
        if (getPlace() != null) {
            _hashCode += getPlace().hashCode();
        }
        if (getInstitution() != null) {
            _hashCode += getInstitution().hashCode();
        }
        __hashCodeCalc = false;
        return _hashCode;
    }

    // Type metadata
    private static org.apache.axis.description.TypeDesc typeDesc =
        new org.apache.axis.description.TypeDesc(Lecture.class, true);

    static {
        typeDesc.setXmlType(new javax.xml.namespace.QName("http://example.org/queryLecture", "Lecture"));
        org.apache.axis.description.ElementDesc elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("id");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "id"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "int"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("name");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "name"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("duration");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "duration"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("namehtml");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "namehtml"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("streamurldsl");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "streamurldsl"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("streamurlisdn");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "streamurlisdn"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("streamurllivestream");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "streamurllivestream"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("_abstract");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "abstract"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("languagesId");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "languagesId"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "int"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("logo");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "logo"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "int"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("time");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "time"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("sortdate");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "sortdate"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("livestreamstarttime");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "livestreamstarttime"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("livestreamendtime");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "livestreamendtime"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("place");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "place"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "string"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
        elemField = new org.apache.axis.description.ElementDesc();
        elemField.setFieldName("institution");
        elemField.setXmlName(new javax.xml.namespace.QName("http://example.org/queryLecture", "institution"));
        elemField.setXmlType(new javax.xml.namespace.QName("http://www.w3.org/2001/XMLSchema", "int"));
        elemField.setMinOccurs(0);
        elemField.setNillable(true);
        typeDesc.addFieldDesc(elemField);
    }

    /**
     * Return type metadata object
     */
    public static org.apache.axis.description.TypeDesc getTypeDesc() {
        return typeDesc;
    }

    /**
     * Get Custom Serializer
     */
    public static org.apache.axis.encoding.Serializer getSerializer(
           java.lang.String mechType, 
           java.lang.Class _javaType,  
           javax.xml.namespace.QName _xmlType) {
        return 
          new  org.apache.axis.encoding.ser.BeanSerializer(
            _javaType, _xmlType, typeDesc);
    }

    /**
     * Get Custom Deserializer
     */
    public static org.apache.axis.encoding.Deserializer getDeserializer(
           java.lang.String mechType, 
           java.lang.Class _javaType,  
           javax.xml.namespace.QName _xmlType) {
        return 
          new  org.apache.axis.encoding.ser.BeanDeserializer(
            _javaType, _xmlType, typeDesc);
    }

}
