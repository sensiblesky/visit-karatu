<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:24px 0;">
        <tr><td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e5e7eb;">
                <tr>
                    <td style="background:#1b5545;padding:20px 28px;">
                        <span style="color:#ffffff;font-size:18px;font-weight:bold;">{{ setting('site_name', 'VisitKaratu') }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:28px;">
                        @yield('body')
                    </td>
                </tr>
                <tr>
                    <td style="padding:18px 28px;border-top:1px solid #e5e7eb;color:#9ca3af;font-size:12px;">
                        This is an automated message from {{ setting('site_name', 'VisitKaratu') }}.
                    </td>
                </tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
