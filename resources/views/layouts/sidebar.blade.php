<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('seo-meta.index') }}">
                <i class="bi bi-search"></i>
                <span>SEO Meta Tags</span>
            </a>
        </li>
        <!-- End SEO Meta Tags Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('global-scripts.edit') }}">
                <i class="bi bi-code-slash"></i>
                <span>Global Scripts</span>
            </a>
        </li>
        <!-- End Global Scripts Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('contact.index') }}">
                <i class="bi bi-envelope"></i>
                <span>Enquiry Form</span>
            </a>
        </li>
        <!-- End Enquiry Form Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-envelope"></i>
                <span>Subscribe Form</span>
            </a>
        </li>
        <!-- End Subscribe Form Nav -->

    </ul>

</aside><!-- End Sidebar-->
