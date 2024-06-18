<!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark "
                  href="/admin/dashboard"
                  aria-expanded="false"
                  ><i class="mdi mdi-view-dashboard"></i
                  ><span class="hide-menu">Dashboard</span></a
                >
              </li>
              <li class="sidebar-item {{ (request()->is('admin/useredit*') || request()->is('admin/artistedit*') || request()->is('admin/user*') || request()->is('admin/artist*')) ? 'selected' : '' }}">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark {{ (request()->is('admin/useredit*') || request()->is('admin/user*') || request()->is('admin/artist*')) ? 'active' : '' }}"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="fas fa-users"></i
                  ><span class="hide-menu">User Management</span></a
                >
                <ul aria-expanded="false" class="collapse first-level {{ (request()->is('admin/useredit*') || request()->is('admin/artistedit*') || request()->is('admin/user*') || request()->is('admin/artist*')) ? 'in' : '' }}">
                  <li class="sidebar-item">
                    <a href="/admin/user" class="sidebar-link {{ (request()->is('admin/useredit*') || request()->is('admin/user*')) ? 'active' : '' }}"
                      ><i class="fas fa-user-plus"></i
                      ><span class="hide-menu">Fan Users</span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="/admin/artist" class="sidebar-link {{ (request()->is('admin/artistedit*') || request()->is('admin/artist*')) ? 'active' : '' }}"
                      ><i class="fas fa-user-plus"></i
                      ><span class="hide-menu">Artists </span></a
                    >
                  </li>
                </ul>
              </li>


                <li class="sidebar-item {{ (request()->is('admin/cmsedit*')) ? 'selected' : '' }}">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/cms"
                  aria-expanded="false"
                  ><i class="fas fa-book"></i
                  ><span class="hide-menu">CMS Management</span></a
                >
                
              </li>

               <li class="sidebar-item {{ (request()->is('admin/adminedit*') || request()->is('admin/admin*')) ? 'selected' : '' }}">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/admin"
                  aria-expanded="false"
                  ><i class="fas fa-columns"></i
                  ><span class="hide-menu">Admin Management</span></a
                >
                
              </li>
               <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/introductory"
                  aria-expanded="false"
                  ><i class="fas fa-columns"></i
                  ><span class="hide-menu">Introductory Management</span></a
                >
                
              </li>
               <li class="sidebar-item {{ (request()->is('admin/eventedit*') || request()->is('admin/event*')) ? 'selected' : '' }}">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/event"
                  aria-expanded="false"
                  ><i class="fas fa-briefcase"></i><span class="hide-menu">Event Management</span></a
                >
                
              </li>
               <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/payment"
                  aria-expanded="false"
                  ><i class='	fas fa-seedling'></i><span class="hide-menu">Payment Management</span></a
                >
                
              </li>
               <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/action"
                  aria-expanded="false"
                  ><i class='fas fa-handshake'></i><span class="hide-menu">Action File Management</span></a
                >
                
              </li>
               <li class="sidebar-item {{ (request()->is('admin/audioedit*')) ? 'selected' : '' }}">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/audio"
                  aria-expanded="false"
                  ><i class='fa fa-music'></i><span class="hide-menu">Audio File Management</span></a
                >
                
              </li>
               <li class="sidebar-item {{ (request()->is('admin/bufferedit*') || request()->is('admin/buffer*')) ? 'selected' : '' }}">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/buffer"
                  aria-expanded="false"
                  ><i class='fa fa-play-circle'></i><span class="hide-menu">Buffer Management</span></a
                >
                
              </li>

              <li class="sidebar-item {{ (request()->is('admin/subscriptionplanedit*') || request()->is('admin/subscriptionplan*')) ? 'selected' : '' }}">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/subscriptionplan"
                  aria-expanded="false"
                  ><i class="fas fa-map"></i
                  ><span class="hide-menu">Subscription Plan</span></a
                >
                
              </li>
              <li class="sidebar-item {{ (request()->is('admin/contactedit*')) ? 'selected' : '' }}">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/contactcms"
                  aria-expanded="false"
                  ><i class="fas fa-address-book"></i
                  ><span class="hide-menu">CMS Contact</span></a
                >
                
              </li>

              <li class="sidebar-item {{ (request()->is('admin/settingedit*') || request()->is('admin/setting*')) ? 'selected' : '' }}">
                <a
                  class="sidebar-link waves-effect waves-dark"
                  href="/admin/setting"
                  aria-expanded="false"
                  ><i class="fas fa-cogs"></i
                  ><span class="hide-menu">Settings</span></a
                >
                
              </li>



           <!--    <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="charts.html"
                  aria-expanded="false"
                  ><i class="mdi mdi-chart-bar"></i
                  ><span class="hide-menu">Charts</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="widgets.html"
                  aria-expanded="false"
                  ><i class="mdi mdi-chart-bubble"></i
                  ><span class="hide-menu">Widgets</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="tables.html"
                  aria-expanded="false"
                  ><i class="mdi mdi-border-inside"></i
                  ><span class="hide-menu">Tables</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="grid.html"
                  aria-expanded="false"
                  ><i class="mdi mdi-blur-linear"></i
                  ><span class="hide-menu">Full Width</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="mdi mdi-receipt"></i
                  ><span class="hide-menu">Forms </span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="form-basic.html" class="sidebar-link"
                      ><i class="mdi mdi-note-outline"></i
                      ><span class="hide-menu"> Form Basic </span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="form-wizard.html" class="sidebar-link"
                      ><i class="mdi mdi-note-plus"></i
                      ><span class="hide-menu"> Form Wizard </span></a
                    >
                  </li>
                </ul>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="pages-buttons.html"
                  aria-expanded="false"
                  ><i class="mdi mdi-relative-scale"></i
                  ><span class="hide-menu">Buttons</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="mdi mdi-face"></i
                  ><span class="hide-menu">Icons </span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="icon-material.html" class="sidebar-link"
                      ><i class="mdi mdi-emoticon"></i
                      ><span class="hide-menu"> Material Icons </span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="icon-fontawesome.html" class="sidebar-link"
                      ><i class="mdi mdi-emoticon-cool"></i
                      ><span class="hide-menu"> Font Awesome Icons </span></a
                    >
                  </li>
                </ul>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="pages-elements.html"
                  aria-expanded="false"
                  ><i class="mdi mdi-pencil"></i
                  ><span class="hide-menu">Elements</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="mdi mdi-move-resize-variant"></i
                  ><span class="hide-menu">Addons </span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="index2.html" class="sidebar-link"
                      ><i class="mdi mdi-view-dashboard"></i
                      ><span class="hide-menu"> Dashboard-2 </span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="pages-gallery.html" class="sidebar-link"
                      ><i class="mdi mdi-multiplication-box"></i
                      ><span class="hide-menu"> Gallery </span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="pages-calendar.html" class="sidebar-link"
                      ><i class="mdi mdi-calendar-check"></i
                      ><span class="hide-menu"> Calendar </span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="pages-invoice.html" class="sidebar-link"
                      ><i class="mdi mdi-bulletin-board"></i
                      ><span class="hide-menu"> Invoice </span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="pages-chat.html" class="sidebar-link"
                      ><i class="mdi mdi-message-outline"></i
                      ><span class="hide-menu"> Chat Option </span></a
                    >
                  </li>
                </ul>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="mdi mdi-account-key"></i
                  ><span class="hide-menu">Authentication </span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="authentication-login.html" class="sidebar-link"
                      ><i class="mdi mdi-all-inclusive"></i
                      ><span class="hide-menu"> Login </span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="authentication-register.html" class="sidebar-link"
                      ><i class="mdi mdi-all-inclusive"></i
                      ><span class="hide-menu"> Register </span></a
                    >
                  </li>
                </ul>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="mdi mdi-alert"></i
                  ><span class="hide-menu">Errors </span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="error-403.html" class="sidebar-link"
                      ><i class="mdi mdi-alert-octagon"></i
                      ><span class="hide-menu"> Error 403 </span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="error-404.html" class="sidebar-link"
                      ><i class="mdi mdi-alert-octagon"></i
                      ><span class="hide-menu"> Error 404 </span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="error-405.html" class="sidebar-link"
                      ><i class="mdi mdi-alert-octagon"></i
                      ><span class="hide-menu"> Error 405 </span></a
                    >
                  </li>
                  <li class="sidebar-item">
                    <a href="error-500.html" class="sidebar-link"
                      ><i class="mdi mdi-alert-octagon"></i
                      ><span class="hide-menu"> Error 500 </span></a
                    >
                  </li> -->

                </ul>
              </li>
             <!--  <li class="sidebar-item p-3">
                <a
                  href="https://github.com/wrappixel/matrix-admin-bt5"
                  target="_blank"
                  class="
                    w-100
                    btn btn-cyan
                    d-flex
                    align-items-center
                    text-white
                  "
                  ><i class="mdi mdi-cloud-download font-20 me-2"></i>Download
                  Free</a
                >
              </li> -->
            </ul>
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->