@include('email.layout.header')
<body id="email">
    <div style="text-align: center;">
        <img src="{{url('main/assets/img/logo.png')}}" style="text-align: center;">
    </div>
    <div style="font-size: 18px;"> Careers</div>
    <table width="100%" cellpadding="0" cellspacing="0" style="min-width:100%;">
    <thead>
      <tr style="background: black; color: aliceblue;">
        <th scope="col" style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:20px;line-height:30px">Email</th>
        <th scope="col" style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:20px;line-height:30px">Subject</th>
        <th scope="col" style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:20px;line-height:30px">Message</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td valign="top" style="padding: 20px; text-align: center; font-family: Arial,sans-serif; font-size: 16px; line-height: 20px; background: antiquewhite;">
            {{ $user_email}}
        </td>
        <td valign="top" style="padding: 20px; text-align: center; font-family: Arial,sans-serif; font-size: 16px; line-height: 20px; background: antiquewhite;">
           {{ $subject }}
        </td>
        <td valign="top" style="padding: 20px; text-align: center; font-family: Arial,sans-serif; font-size: 16px; line-height: 20px; background: antiquewhite;">
            {{ $text}}
        </td>
      </tr>
    </tbody>
</table>
@include('email.layout.footer')
</body>

</html>