<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>@yield('title')</title>
    </head>
<body style="margin:0px; background: #f8f8f8;">
    <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
      <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px;">
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px;">
          <tbody>
            <tr>
              <td style="vertical-align: top; padding-bottom:30px;" align="center"><a href="javascript:void(0)" target="_blank"><img src="{{ asset('imgs') }}/{{ config('app.app_email_logo') }}" alt="{{ config('app.app_email_title') }}" style="border:none;"></a> </td>
            </tr>
          </tbody>
        </table>
        <div style="padding: 40px; background: #fff;">
          <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
            <tbody>
              <tr>
                <td style="border-bottom:1px solid #f6f6f6;"><h1 style="font-size:14px; font-family:arial; margin:0px; font-weight:bold;">Hello {{ $email_data->user_name }},</h1>
                  <p style="margin-top:0px; color:#bbbbbb;">{{ $email_data->email_subject }}</p>
                  <p style="margin-top:0px; color:#bbbbbb;">Submission Title: {{ $email_data->submission_name }}</p></td>
              </tr>
              <tr>
                <td style="padding:10px 0 30px 0;"><p>{{ $email_data->reporter_name }}'s story is now live on okayplayer.com. Click <a href="{{ $email_data->story_link }}">here</a> to view the story.<br>
                
                </p>
                  <center>
                    <a href="{{ $email_data->story_link }}" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #00c0c8; border-radius: 60px; text-decoration:none;">Share This Story Button</a>
                  </center>
                  <b>The Byline Project —</b> </td>
              </tr>
              
            </tbody>
          </table>
        </div>
        <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px;">
          <p> Powered by BYLINE <br>
            <a href="javascript: void(0);" style="color: #b2b2b5; text-decoration: underline;">Unsubscribe</a> </p>
        </div>
      </div>
    </div>
</body>
</html>