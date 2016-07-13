<html>
<head>
	<title>{{ $invoice->name }}</title>
	<link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="right" colspan="2" height="100">
			<h1>INVOICE</h1>
		</td>
	</tr>
	<tr>
		<td valign="top" width="70%" style="line-height:20px">
			{!! $address->body !!}<br />
			<strong>{{ $client->name }}</strong>
			{!! $client->address !!}
		</td>
		<td valign="top" width="30%" style="line-height:25px">
			INVOICE NUMBER: {{ $invoice->name }}<br />
			DATE: {{ date('d/m/Y', strtotime($invoice->invoiced)) }}<br />
			DUE DATE: {{ date('d/m/Y', strtotime($invoice->due)) }}
		</td>
	</tr>
	<tr height="30"><td height="30"></td></tr>
</table>
<table width="100%" cellpadding="5" cellspacing="4" border="1" class="details">
	<tr>
		<td><strong>Start</strong></td>
		<td><strong>Complete</strong></td>
		<td><strong>Description</strong></td>
		<td align="right"><strong>Amount ({{ $currency_symbols[$invoice->currency_id] }})</strong></td>
	</tr>
	@foreach ($jobs as $job)
		<tr>
			<td>{{ date('d/m/Y', strtotime($job->started)) }}</td>
			<td>{{ date('d/m/Y', strtotime($job->completed)) }}</td>
			<td>{{ $job->name }}</td>
			<td align="right">{{ number_format($job->amount, 2) }}</td>
		</tr>
	@endforeach
	<tr>
		<td colspan="4" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<strong>TOTAL:</strong>
				</td>
				<td>
					<strong>{{ $currency_symbols[$invoice->currency_id] . number_format($invoice->amount, 2) }}</strong>
				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
