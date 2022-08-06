<!-- Brand Logo -->
    <a href="{{ asset('/home') }}" class="brand-link">
      <img src="{{ url('admin/dist/img/settings',$settings->company_logo) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{$settings->company_name}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          {{-- <img src="{{ asset('admin/dist/img/user.jpg') }}" class="img-circle elevation-2" alt="User Image"> --}}
        </div>
        <div class="info">
          <a href="{{ route('user.profile') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="{{ asset('/home') }}" class="{{ \Request::is('home') || \Request::is('home/') ? 'nav-link active' : 'nav-link'  }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
                <i class="right fas"></i>
              </p>
            </a>
          </li>
          @role('super-admin')
          <li class="{{ \Request::is('user/*') || \Request::is('user/') ? 'nav-item menu-is-opening menu-open ' : 'nav-item'  }}">
            <a href="#" class="{{ \Request::is('user/*') || \Request::is('user/') ? 'nav-link active' : 'nav-link'  }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @role('super-admin')
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="{{ \Request::is('user/roles') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Role</p>
                </a>
              </li>
              @endrole
              @role('super-admin')
              <li class="nav-item">
                <a href="{{ route('permissions.index') }}" class="{{ \Request::is('user/permissions') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permission</p>
                </a>
              </li>
              @endrole
              @role('super-admin')
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="{{ \Request::is('user/users') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              @endrole

            </ul>
          </li>
          @endrole

          @role('super-admin|store')
            <li class="{{ \Request::is('employee/*') || \Request::is('employee/') ? 'nav-item menu-is-opening menu-open ' : 'nav-item'  }}">
              <a href="{{ route('employee.index') }}" class="{{ \Request::is('employee') ? 'nav-link active' : 'nav-link'  }}">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>Employee</p>
              </a>
            </li>
          @endrole

          <li class="{{ \Request::is('yarn/*') || \Request::is('yarn/') ? 'nav-item menu-is-opening menu-open ' : 'nav-item'  }}">
            <a href="#" class="{{ \Request::is('yarn/*') || \Request::is('yarn/') ? 'nav-link active' : 'nav-link'  }}">
              <i class="nav-icon fab fa-cotton-bureau"></i>
              <p>
                Yarn
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @role('super-admin')
              <li class="nav-item">
                <a href="{{ route('party.index') }}" class="{{ \Request::is('yarn/party') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Party</p>
                </a>
              </li>
              @endrole
              @role('super-admin|store|Accounts')
              <li class="nav-item">
                <a href="{{ route('receive_yarn.index') }}" class="{{ \Request::is('yarn/receive_yarn') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="fab fa-yarn nav-icon"></i>
                  <p>Receive Yarn</p>
                </a>
              </li>
              @endrole
              @role('super-admin|store|Accounts')
              <li class="nav-item">
                <a href="{{ route('return_yarn.index') }}" class="{{ \Request::is('yarn/return_yarn') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="fas fa-undo-alt nav-icon"></i>
                  <p>Return Yarn</p>
                </a>
              </li>
              @endrole
              @role('super-admin|store|Accounts')
              <li class="nav-item">
                <a href="{{ route('yarn_stock.index') }}" class="{{ \Request::is('yarn/yarn_stock') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="fas fa-layer-group nav-icon"></i>
                  <p>Yarn Stock</p>
                </a>
              </li>
              @endrole
              @role('super-admin|store|Accounts')
              <li class="nav-item">
                <a href="{{ route('knitting.index') }}" class="{{ \Request::is('yarn/knitting') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="fab fa-critical-role nav-icon"></i>
                  <p>Knitting Program</p>
                </a>
              </li>
              @endrole
            </ul>
          </li>

          <li class="{{ \Request::is('fabric/*') || \Request::is('fabric/') ? 'nav-item menu-is-opening menu-open ' : 'nav-item'  }}">
            <a href="#" class="{{ \Request::is('fabric/*') || \Request::is('fabric/') ? 'nav-link active' : 'nav-link'  }}">
              <i class="fas fa-scroll nav-icon"></i>
              <p>
                Fabric
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @role('super-admin|store|Accounts')
              <li class="nav-item">
                <a href="{{ route('fabric_receive.index') }}" class="{{ \Request::is('fabric/fabric_receive') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fabric Receive</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('fabric_stock.get') }}" class="{{ \Request::is('fabric/fabric_stock') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fabric Stock(Receive)</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('fabric_delivery.index') }}" class="{{ \Request::is('fabric/fabric_delivery') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fabric Delivery(Received)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('fabric_delivery.prod.index') }}" class="{{ \Request::is('fabric/fabric-delivery/production/index') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fabric Delivery(Production)</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('production.index') }}" class="{{ \Request::is('fabric/production') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Production</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('fabric_stock_production.get') }}" class="{{ \Request::is('fabric/fabric_stock_production') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fabric Stock(Production)</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('daily.daily_production') }}" class="{{ \Request::is('fabric/daily_production') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daily Production</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('weekly.production_report') }}" class="{{ \Request::is('fabric/weekly') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Weekly Production</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('monthly.production_report') }}" class="{{ \Request::is('fabric/monthly_production_report') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Production</p>
                </a>
              </li>
              @endrole
            </ul>
          </li>

           <li class="{{ \Request::is('party-order/*') || \Request::is('party-order/') ? 'nav-item menu-is-opening menu-open ' : 'nav-item'  }}">
            <a href="#" class="{{ \Request::is('party-order/*') || \Request::is('party-order/') ? 'nav-link active' : 'nav-link'  }}">
              <i class="fas fa-scroll nav-icon"></i>
              <p>
                Party Order
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @role('super-admin|store|Accounts')
              <li class="nav-item">
                <a href="{{ url('party-order') }}" class="{{ \Request::is('party-order') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Party Order Details</p>
                </a>
              </li>

              @endrole
            </ul>
          </li>

          <li class="{{ \Request::is('account/*') || \Request::is('account/') ? 'nav-item menu-is-opening menu-open ' : 'nav-item'  }}">
            <a href="#" class="{{ \Request::is('account/*') || \Request::is('account/') ? 'nav-link active' : 'nav-link'  }}">
              <i class="fas fa-file-invoice-dollar nav-icon"></i>
              <p>
                Accounts
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @role('super-admin|store|Accounts')
                <li class="{{ \Request::is('account/bill*') || \Request::is('account/bill') ? 'nav-item menu-is-opening menu-open ' : 'nav-item'  }}">
                    <a href="#" class="{{ \Request::is('account/bill*') || \Request::is('account/bill') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="nav-icon fas fa-money-bill"></i>
                  <p>
                    Billing
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('bill.index') }}" class="{{ \Request::is('account/bill') ? 'nav-link active' : 'nav-link'  }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Paid Bill</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('bill-due.index') }}" class="{{ \Request::is('account/bill-due/index') ? 'nav-link active' : 'nav-link'  }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Due Bill</p>
                    </a>
                  </li>
                </ul>
              </li>
              @endrole
              @role('super-admin|store|Accounts')
              <li class="nav-item">
                <a href="{{ route('delivery-bill.index') }}" class="{{ \Request::is('account/delivery-bill') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="fas fa-money-check"></i>
                  <p>Delivery Bill</p>
                </a>
              </li>
              @endrole
              @role('super-admin|store|Accounts')
              <li class="nav-item">
                <a href="{{ route('bill.ledger') }}" class="{{ \Request::is('account/bill_ledger') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="fas fa-money-bill-alt"></i>
                  <p>Bill Ledger</p>
                </a>
              </li>
              @endrole
              @role('super-admin|store|Accounts')
              <li class="nav-item">
                <a href="{{ route('revenue.index') }}" class="{{ \Request::is('account/revenue') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="fas fa-money-bill-alt nav-icon"></i>
                  <p>Revenue</p>
                </a>
              </li>
              @endrole
              @role('super-admin|store|Accounts')
              <li class="nav-item">
                <a href="{{ route('expense.index') }}"class="{{ \Request::is('account/expense') ? 'nav-link active' : 'nav-link'  }}">
                  <i class="fas fa-hand-holding-usd nav-icon"></i>
                  <p>Expense</p>
                </a>
              </li>
              @endrole
            </ul>
          </li>
          @role('super-admin')
            <li class="{{ \Request::is('settings/*') || \Request::is('settings/') ? 'nav-item menu-is-opening menu-open ' : 'nav-item'  }}">
              <a href="{{ route('setting.index') }}" class="{{ \Request::is('settings/setting') ? 'nav-link active' : 'nav-link'  }}">
                <i class="fas fa-cogs nav-icon"></i>
                <p>Settings</p>
              </a>
            </li>
          @endrole
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
