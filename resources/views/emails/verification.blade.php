<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
    <meta name="format-detection" content="telephone=no" />
    <style>
        body {
            margin: 0;
            padding: 0;
            min-width: 100%;
            width: 100% !important;
            height: 100% !important;
            max-width: 800px;
            line-height: 140% !important;
        }
        body,
        table,
        td,
        div,
        p,
        a {
            -webkit-font-smoothing: antialiased;
            text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        img{
          max-width: 100%;
        }
        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            border-collapse: collapse !important;
            border-spacing: 0;
        }

        img {
            border: 0;
            line-height: 140%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        #outlook a {
            padding: 0;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 140%
        }

        @media all and (min-width: 560px) {
            .container {
                border-radius: 8px;
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                -khtml-border-radius: 8px;
            }
        }

        a,
        a:hover {
            color: #127DB3;
        }

        .footer a,
        .footer a:hover {
            color: #999999;
        }
    </style>

    <title>{{ $subject }}</title>

</head>

<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 140%
	background-color: #F0F0F0;
	color: #000000;" bgcolor="#F0F0F0" text="#000000">
    <table width="100%" style="min-width: 400px" align="center" border="0" cellpadding="0" cellspacing="0"
        style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;" class="background">
        <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;"
                bgcolor="#F0F0F0">
                <table border="0" cellpadding="0" cellspacing="0" align="center" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
	max-width: 560px;" class="wrapper">

                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
			padding-top: 20px;
			padding-bottom: 20px;">
                            <div style="display: none; visibility: hidden; overflow: hidden; opacity: 0; font-size: 1px; line-height: 1px; height: 0; max-height: 0; max-width: 0;
			color: #F0F0F0;" class="preheader">
                                {{ $subject }}</div>
                            <a target="_blank" style="text-decoration: none;" href="{{ $site_url }}"><img border="0"
                                    vspace="0" hspace="0" src="{{ $logo }}" height="40" alt="Logo"
                                    title="Logo"
                                    style="
				color: #000000;
				font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;" /></a>

                        </td>
                    </tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
	max-width: 560px;" class="container">
                    <tr>
                        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 24px; font-weight: bold; line-height: 130%;
			padding-top: 25px;
			color: #000000;
			font-family: sans-serif;" class="header">
                            {{ $subject }}
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="box-sizing: border-box; border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
			padding-top: 25px;
			color: #000000;
			font-family: sans-serif;">
        <img src="{{ url('/') }}/email/verification.jpg" alt="">
      </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
			padding-top: 25px;
			color: #000000;
			font-family: sans-serif;" class="paragraph">
        <h2>Hi, {{ $name }}</h2>
        <p>Welcome to us. Your account has been successfully created. To log in to your account, you need to confirm your e-mail address. Please confirm your email address by clicking the link below.</p>
      </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
			padding-top: 25px;
			padding-bottom: 5px;" class="button"><a href="{{ $site_url }}" target="_blank">
                                <table border="0" cellpadding="0" cellspacing="0" align="center"
                                    style="max-width: 240px; min-width: 120px; border-collapse: collapse; border-spacing: 0; padding: 0;">
                                    <tr>
                                        <td align="center" valign="middle"
                                            style="padding: 12px 24px; margin: 0;  border-collapse: collapse; border-spacing: 0; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px;"
                                            bgcolor="#E9703E"><a target="_blank"
                                                style="
					color: #FFFFFF; font-family: sans-serif; font-size: 17px; font-weight: 400; line-height: 120%; text-decoration: none !important;"
                                                href="{{ $verification_url }}">
                                                {{ __('Confirm My Email') }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
			padding-top: 25px;" class="line">
                            <hr color="#E0E0E0" align="center" width="100%" size="1" noshade
                                style="margin: 0; padding: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
