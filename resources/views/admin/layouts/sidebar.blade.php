@if ( ! Auth::guest())
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview @if ($method == 'jobs') {{ 'active' }} @endif">
                <a href="#">Jobs</a>
                <ul class="treeview-menu">
                    <li @if ($method == 'jobs' && $argument == 'open') {!! 'class="active"' !!} @endif><a href="{{ url('jobs/open') }}">Open jobs ({{ $openJobs }})</a></li>
                    <li @if ($method == 'jobs' && $argument == 'completed') {!! 'class="active"' !!} @endif><a href="{{ url('jobs/completed') }}">Done, not invoiced ({{ $doneNotInvoiced }})</a></li>
                    <li @if ($method == 'jobs' && $argument == '') {!! 'class="active"' !!} @endif><a href="{{ url('jobs') }}">All jobs ({{ $allJobs }})</a></li>
                    <li @if ($method == 'jobs' && $argument == 'create') {!! 'class="active"' !!} @endif><a href="{{ url('jobs/create') }}">Add a job</a></li>
                </ul>
            </li>
            <li class="treeview @if ($method == 'invoices') {{ 'active' }} @endif">
                <a href="#">Invoices</a>
                <ul class="treeview-menu">
                    <li @if ($method == 'invoices' && $argument == 'overdue') {!! 'class="active"' !!} @endif><a href="{{ url('invoices/overdue') }}">Overdue invoices ({{ $overdueInvoices }})</a></li>
                    <li @if ($method == 'invoices' && $argument == 'not-due') {!! 'class="active"' !!} @endif><a href="{{ url('invoices/not-due') }}">Not due invoices ({{ $notDueInvoices }})</a></li>
                    <li @if ($method == 'invoices' && $argument == '') {!! 'class="active"' !!} @endif><a href="{{ url('invoices') }}">All invoices ({{ $allInvoices }})</a></li>
                    <li @if ($method == 'invoices' && $argument == 'create') {!! 'class="active"' !!} @endif><a href="{{ url('invoices/create') }}">Add an invoice</a></li>
                </ul>
            </li>
            <li class="treeview @if ($method == 'clients' || $method == 'projects' || $method == 'currencies' || $method == 'banks' || $method == 'text') {{ 'active' }} @endif">
                <a href="#">Admin</a>
                <ul class="treeview-menu">
                    <li @if ($method == 'clients') {!! 'class="active"' !!} @endif><a href="{{ url('clients') }}">Clients</a></li>
                    <li @if ($method == 'projects') {!! 'class="active"' !!} @endif><a href="{{ url('projects') }}">Projects</a></li>
                    <li @if ($method == 'currencies') {!! 'class="active"' !!} @endif><a href="{{ url('currencies') }}">Currencies</a></li>
                    <li @if ($method == 'banks') {!! 'class="active"' !!} @endif><a href="{{ url('banks') }}">Banks</a></li>
                    <li @if ($method == 'text' && $argument == '1') {!! 'class="active"' !!} @endif><a href="{{ url('text/1') }}">Invoice Address</a></li>
                    <li @if ($method == 'text' && $argument == '2') {!! 'class="active"' !!} @endif><a href="{{ url('text/2') }}">Invoice Footer</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
@endif