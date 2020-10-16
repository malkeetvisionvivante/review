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
												  <h2 style="margin:0;padding: 0;">Sign up user duplication alert: user sign up potential identity conflict</h2>
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
																<p>Potential user duplication from user sign up. </p>
																<p>Email : <strong>{{ $user_email }}</strong></p>
																<p>First Name : <strong> {{ $first_name }}</strong></p>
																<p>Last Name : <strong> {{ $last_name }}</strong></p>
																<p>Created At : <strong> {{ $created_at }}</strong></p>
															</div>
														</td>
													</tr>
													<tr>
														<td valign="top">
															<div id="body_content_inner">
																<h1>conflict with</h1>
															</div>
														</td>
													</tr>
													@foreach($users as $user)
													<tr>
														<td valign="top">
															<div id="body_content_inner">
																<p>Email : <strong>{{ $user->email }}</strong></p>
																<p>First Name : <strong> {{ $user->name }}</strong></p>
																<p>Last Name : <strong> {{ $user->last_name }}</strong></p>
																<p>Created At : <strong> {{ $user->created_at }}</strong></p>
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
									  	<span>Copyright @2020</span><span class="agentconnect-color"> Reviews </span><span> All right reserved </span>
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
