<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/profile_small.jpg" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <li class="active">
                <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Sistema</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href=" {{ route('users.listGet') }} ">Usuários</a></li>
                    <li><a href=" {{ route('roles.listGet') }} ">Grupos</a></li>
                    <li><a href=" {{ route('acl.refresh') }} ">Acl - Refresh</a></li>
                    <li><a href=" {{ route('menus.listGruposGet') }} ">Menus</a></li>

                    <li class="active"><a href="empty_page.html">Empty page</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Financeiro</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href=" {{ route('accounts.listGet') }} ">Contas</a></li>
                    <li><a href=" {{ route('accounts.create') }} ">Criar contas</a></li>
                    <li><a href=" {{ route('accounts.teste') }} ">Teste credit</a></li>
                </ul>
            </li>

        </ul>

    </div>
</nav>
