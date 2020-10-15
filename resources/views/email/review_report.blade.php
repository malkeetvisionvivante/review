<!DOCTYPE html>
<html lang="en">
  <head>
    <title>title</title>
     <meta charset="utf-8">
  </head>
  <body  marginwidth="0" topmargin="0" marginheight="0" offset="0">
    <div id="wrapper" dir="rt">
      <table> 
        <tr>
          <td>          
            <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
              <tr>
                <td align="center" valign="top">
                  <!-- Header -->
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header">
                    <tr>
                      <td id="header_wrapper">
                        <header style="background-color: #85be39;padding: 10px;text-align: left;font-size: 20px;color: white;">
                          @if($count <= 1)
                          <h2 style="margin:0;padding: 0;">Review has been reported by {{ $count }} User</h2>
                          @else
                           <h2 style="margin:0;padding: 0;">Review has been reported by {{ $count }} Users</h2>
                          @endif
                        </header>
                      </td>
                    </tr>
                  </table>
                  <!-- End Header -->
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <!-- Body -->
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                    <tr>
                      <td valign="top" id="body_content">
                        <!-- Content -->
                        <table border="0" cellpadding="20" cellspacing="0" width="100%">
                          <tr>
                            <td valign="top">
                              <div id="body_content_inner">
                                <h1>Hi, Admin</h1>
                                <h1>Report On</h1>
                                <p>Manager Name : <strong>{{ $to_name }}</strong></p>
                                <p>Manager Email : <strong>{{ $to_email }}</strong></p>
                                <p>Comment : <strong>{{ $comment }}</strong></p>
                                <h4>These are the users who Reported</h4>
                              </div>
                            </td>
                          </tr>
                          @foreach($reviewData as $review)
                          <tr>
                            <td valign="top">
                              <div id="body_content_inner">
                                <p>Email : <strong>{{ $review->customer_Email() }}</strong></p>
                                <p>Name : <strong> {{ $review->customer_name() }}</strong></p>
                                <p>Reported at : <strong> {{ $review->created_at }}</strong></p>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                        </table>
                        <!-- End Content -->
                      </td>
                    </tr>
                  </table>
                  <!-- End Body -->
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <div class="header" style="overflow: hidden;background-color: #f1f1f1;text-align: center;color: #000000; padding: 20px 10px;">
                      <span>Copyright @2020</span><span class="agentconnect-color"> Blossom Team </span><span> All right reserved </span>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
  </body>
</html>
