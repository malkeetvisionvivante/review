<!DOCTYPE html>
<html lang="en">
	<head>
		<title>title</title>
		 <meta charset="utf-8">
	</head>
	<body>
		<div>
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
												  <h2 style="margin:0;padding: 0;">{{ $title }}</h2>
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
																<p>Subject : <strong>{{ $subject }}</strong></p>
																<p>Company Name : <strong>{{ $company_name }}</strong></p>
																<p>Email : <strong>{{ $user_email }}</strong></p>
																<p>Message : <strong> {{ $text }}</strong></p>
																<p>From  : <strong> Footer `Add your company` link </strong></p>
															</div>
														</td>
													</tr>
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
