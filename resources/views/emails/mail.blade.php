<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <!-- NAME: TELL A STORY -->
    <!--[if gte mso 15]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>*|MC:SUBJECT|*</title>

</head>

<body>

<center>

    <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0" width="600px">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0;margin-bottom:20px;padding-bottom:20px;border-bottom:solid 1px #cccccc;" width="100%">
                    <tr>
                        <td align="center" width="100%">
                            <p style="font-size:30px;font-weight:100;">
                                <img style="height:60px;margin-right:10px;margin-bottom:-20px;" src="{{url('/images/logo.png')}}" alt="">

                            </p>
                            <p style="font-size:30px;font-weight:100;"><p style="font-size:30px;font-weight:100;">@yield('subject')</p>
                        </td>
                    </tr>
                </table>

                <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0" width="600px">
                    <tr>
                        <td width="100%">

                            @yield('content')

                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</center>
</body>
