@if ( ! Auth::guest())
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview @if ($method == 'jobs') {{ 'active' }} @endif">
                <a href="#">Jobs</a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/jobs/open') }}">Open jobs ({{ $openJobs }})</a></li>
                    <li><a href="{{ url('admin/jobs/completed') }}">Done, not invoiced ({{ $doneNotInvoiced }})</a></li>
                    <li><a href="{{ url('admin/jobs') }}">All jobs ({{ $allJobs }})</a></li>
                    <li><a href="{{ url('admin/jobs/create') }}">Add a job</a></li>
                </ul>
            </li>
            <li class="treeview @if ($method == 'invoices') {{ 'active' }} @endif">
                <a href="#">Invoices</a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/invoices/overdue') }}">Overdue invoices ({{ $overdueInvoices }})</a></li>
                    <li><a href="{{ url('admin/invoices/not-due') }}">Not due invoices ({{ $notDueInvoices }})</a></li>
                    <li><a href="{{ url('admin/invoices') }}">All invoices ({{ $allInvoices }})</a></li>
                    <li><a href="{{ url('admin/invoices/create') }}">Add an invoice</a></li>
                </ul>
            </li>
            <li class="treeview @if ($method == 'clients' || $method == 'projects' || $method == 'currencies' || $method == 'banks' || $method == 'text') {{ 'active' }} @endif">
                <a href="#">Admin</a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/clients') }}">Clients</a></li>
                    <li><a href="{{ url('admin/projects') }}">Projects</a></li>
                    <li><a href="{{ url('admin/currencies') }}">Currencies</a></li>
                    <li><a href="{{ url('admin/banks') }}">Banks</a></li>
                    <li><a href="{{ url('admin/text/1') }}">Invoice Address</a></li>
                    <li><a href="{{ url('admin/text/2') }}">Invoice Footer</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
@endif