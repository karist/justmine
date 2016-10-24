<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:str="http://exslt.org/strings" xmlns:php="http://php.net/xsl" exclude-result-prefixes="exslt str php">

    <xsl:output encoding="UTF-8" method="xml" omit-xml-declaration="yes" indent="yes"
                doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" cdata-section-elements="script"/>

    <xsl:template match="/">

        <head>
            <title>Laravel</title>

            <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"/>

            <style>
                html, body {
                height: 100%;
                }

                body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                }

                .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
                }

                .content {
                text-align: center;
                display: inline-block;
                }

                .title {
                font-size: 96px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="content">
                    <div class="title">Laravel 5 XSLT engine template</div>
                </div>
            </div>
        </body>
    </xsl:template>

</xsl:stylesheet>