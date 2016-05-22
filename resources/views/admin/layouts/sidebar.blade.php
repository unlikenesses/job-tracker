@if ( ! Auth::guest())
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview @if ($method == 'jobs') {{ 'active' }} @endif">
                <a href="#">Jobs</a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/jobs/open') }}">Open jobs</a></li>
                    <li><a href="{{ url('admin/jobs/completed') }}">Done, not invoiced</a></li>
                    <li><a href="{{ url('admin/jobs') }}">All jobs</a></li>
                    <li><a href="{{ url('admin/jobs/create') }}">Add a job</a></li>
                </ul>
            </li>
            <li class="treeview @if ($method == 'invoices') {{ 'active' }} @endif">
                <a href="#">Invoices</a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/invoices/overdue') }}">Overdue invoices</a></li>
                    <li><a href="{{ url('admin/invoices/not-due') }}">Not due invoices</a></li>
                    <li><a href="{{ url('admin/invoices') }}">All invoices</a></li>
                    <li><a href="{{ url('admin/invoices/create') }}">Add an invoice</a></li>
                </ul>
            </li>
            <li class="treeview @if ($method == 'clients' || $method == 'projects' || $method == 'currencies') {{ 'active' }} @endif">
                <a href="#">Admin</a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/clients') }}">Clients</a></li>
                    <li><a href="{{ url('admin/projects') }}">Projects</a></li>
                    <li><a href="{{ url('admin/currencies') }}">Currencies</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
@endif