<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml"
		doctype-public="+//IDN python.org//DTD XML Bookmark Exchange Language 1.0//EN//XML"
		doctype-system="http://www.python.org/topics/xml/dtds/xbel-1.0.dtd"
		omit-xml-declaration="no" indent="yes" />
	<xsl:template match="/">
		<xbel version="1.0">
			<xsl:for-each select="Bookmark">
				<bookmark>
					<xsl:attribute name="href">
						<xsl:value-of select="uri" />
					</xsl:attribute>
					<title>
						<xsl:value-of select="title" />
					</title>
					<info>
						<metadata
							owner="http://example.com/documentation/xbel/edit">
 							<xsl:value-of select="$bookmarkuri" />
						</metadata>
						<metadata
							owner="http://example.com/documentation/xbel/tags">
							<xsl:for-each select="tags">
								<xsl:copy-of select="tag" />
							</xsl:for-each>
						</metadata>
					</info>
					<desc>
						<xsl:value-of select="description" />
					</desc>
				</bookmark>
			</xsl:for-each>
		</xbel>
	</xsl:template>

</xsl:stylesheet>
