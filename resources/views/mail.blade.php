<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minty-Multipurpose Responsive Email Template</title>
    <style type="text/css">
        /* Client-specific Styles */
        #outlook a {
            padding: 0;
        }

        /* Force Outlook to provide a "view in browser" menu link. */
        body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
        }

        /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
        .ExternalClass {
            width: 100%;
        }

        /* Force Hotmail to display emails at full width */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
            line-height: 100%;
        }

        /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
        #backgroundTable {
            margin: 0;
            padding: 0;
            width: 100% !important;
            line-height: 100% !important;
        }

        img {
            outline: none;
            text-decoration: none;
            border: none;
            -ms-interpolation-mode: bicubic;
        }

        a img {
            border: none;
        }

        .image_fix {
            display: block;
        }

        p {
            margin: 0px 0px !important;
        }

        table td {
            border-collapse: collapse;
        }

        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        /*a {color: #e95353;text-decoration: none;text-decoration:none!important;}*/
        /*STYLES*/
        table[class=full] {
            width: 100%;
            clear: both;
        }

        /*################################################*/
        /*IPAD STYLES*/
        /*################################################*/
        @media only screen and (max-width: 640px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #ffffff; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #ffffff !important;
                pointer-events: auto;
                cursor: default;
            }

            table[class=devicewidth] {
                width: 440px !important;
                text-align: center !important;
            }

            table[class=devicewidthinner] {
                width: 420px !important;
                text-align: center !important;
            }

            table[class="sthide"] {
                display: none !important;
            }

            img[class="bigimage"] {
                width: 420px !important;
                height: 219px !important;
            }

            img[class="col2img"] {
                width: 420px !important;
                height: 258px !important;
            }

            img[class="image-banner"] {
                width: 440px !important;
                height: 106px !important;
            }

            td[class="menu"] {
                text-align: center !important;
                padding: 0 0 10px 0 !important;
            }

            td[class="logo"] {
                padding: 10px 0 5px 0 !important;
                margin: 0 auto !important;
            }

            img[class="logo"] {
                padding: 0 !important;
                margin: 0 auto !important;
            }

        }

        /*##############################################*/
        /*IPHONE STYLES*/
        /*##############################################*/
        @media only screen and (max-width: 480px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #ffffff; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #ffffff !important;
                pointer-events: auto;
                cursor: default;
            }

            table[class=devicewidth] {
                width: 280px !important;
                text-align: center !important;
            }

            table[class=devicewidthinner] {
                width: 260px !important;
                text-align: center !important;
            }

            table[class="sthide"] {
                display: none !important;
            }

            img[class="bigimage"] {
                width: 260px !important;
                height: 136px !important;
            }

            img[class="col2img"] {
                width: 260px !important;
                height: 160px !important;
            }

            img[class="image-banner"] {
                width: 280px !important;
                height: 68px !important;
            }

        }
    </style>
</head>
<body>
<div class="block">

    <table width="540" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
        <tbody>
        <!-- title -->
        <tr>
            <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:left;line-height: 20px;"
                st-title="rightimage-title">
                <img src="https://files.slack.com/files-pri/T052MDBL4-F2L7P2XEW/transaction_175px-01.jpg?pub_secret=edc185041b" alt="nic" width="200px">
            </td>
        </tr>
        <!-- end of title -->
        <!-- Spacing -->
        <tr>
            <td width="100%" height="10"></td>
        </tr>
        <!-- Spacing -->
        <!-- content -->
        <tr>
            <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #666666; text-align:left;line-height: 24px;"
                st-content="rightimage-paragraph">
                <strong>name:</strong> @if(isset($name)){{$name}}@endif
            </td>
        </tr>
        <tr>
            <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #666666; text-align:left;line-height: 24px;"
                st-content="rightimage-paragraph">
                <strong>email:</strong> @if(isset($email)){{$email}}@endif
            </td>
        </tr>
        @if(!empty($text_message))
        <tr>
            <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #666666; text-align:left;line-height: 24px;"
                st-content="rightimage-paragraph">
                <strong>mesage:</strong> {{$text_message}}
            </td>
        </tr>
        @endif
        <!-- end of content -->
        <!-- Spacing -->

        <!-- button -->

        <!-- /button -->
        <!-- Spacing -->

        <!-- Spacing -->
        </tbody>
    </table>

</div>


</body>
</html>
