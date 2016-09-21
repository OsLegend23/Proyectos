<header>
    <nav class="top-nav amber darken-1" role="navigation">
        <div class="container">
            <div class="nav-wrapper">
                <a id="logo-container" class="brand-logo" href="<?php echo $GLOBAL['domain-root'];?>">
                    <object id="front-page-logo" data="<?php echo $GLOBAL['domain-root'];?>media/image/logoHikingMexico.png">
                        <?php echo $GLOBAL['site'];?>
                    </object>
                </a>
                <?php if($_SESSION['enlaceemp_loginon'])
                {
                ?><!-- Dropdown Structure -->
                    <ul id="dropdown" class="dropdown-content">
                        <li>
                            <a href="<?php echo $COMMON->getRoot().$GLOBAL['user_list'][$_SESSION['enlaceemp_accounttype']]['location'];?>">
                                <?php echo $STR['GoToAdmin'];?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $COMMON->getRoot().'account/?logout';?>"><?php echo $STR['CloseSession'];?></a>
                        </li>
                    </ul>
                        <div class="nav-wrapper">
                            <ul class="right hide-on-med-and-down">
                                <li>
                                    <a id="inicio" href="<?php echo $COMMON->getRoot();?>"><?php echo $STR['Init'];?></a>
                                </li>
                                <li>
                                    <a id="buscarTrabajo" href="<?php echo $COMMON->getRoot().'search/';?>"><?php echo $STR['SearchJob'];?></a>
                                </li>
                                <li>
                                    <a id="registro" href="#modal1" class='modal-trigger'><?php echo $STR['Registry'];?></a>
                                </li>
                                <li>
                                    <a id="soporte" href="<?php echo $COMMON->getRoot().'support/';?>"><?php echo $STR['Support'];?></a>
                                </li>
                                <!-- Dropdown Trigger -->
                                <li>
                                    <a class="dropdown-button" href="#!" data-activates="dropdown">
                                        <?php echo $COMMON->str_replace($STR['WelcomeLogin'], array('{userName}'=>$_SESSION['enlaceemp_accountname']) )?>
                                        <i class="mdi-navigation-arrow-drop-down right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                <?php 
                } else {
                ?>
                    <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
                    <ul id="nav" class="right hide-on-med-and-down">
                        <li>
                            <a id="inicio" href="<?php echo $COMMON->getRoot();?>"><?php echo $STR['Init'];?></a>
                        </li>
                        <li>
                            <a id="buscarTrabajo" href="<?php echo $COMMON->getRoot().'search/';?>"><?php echo $STR['SearchJob'];?></a>
                        </li>
                        <li>
                            <a id="registro" href="#modal1" class='modal-trigger'><?php echo $STR['Registry'];?></a>
                        </li>
                        <li>
                            <a id="soporte" href="<?php echo $COMMON->getRoot().'support/';?>"><?php echo $STR['Support'];?></a>
                        </li>
                        <li>
                            <a href="#" id='signIn'><?php echo $STR['SignIn'];?></a>
                        </li>
                    </ul>
                    <ul id="nav-mobile" class="side-nav">
                        <li>
                            <a id="inicio" href="<?php echo $COMMON->getRoot();?>"><?php echo $STR['Init'];?></a>
                        </li>
                        <li>
                            <a id="buscarTrabajo" href="<?php echo $COMMON->getRoot().'search/';?>"><?php echo $STR['SearchJob'];?></a>
                        </li>
                        <li>
                            <a id="registro" href="#modal1" class='modal-trigger'><?php echo $STR['Registry'];?></a>
                        </li>
                        <li>
                            <a id="soporte" href="<?php echo $COMMON->getRoot().'support/';?>"><?php echo $STR['Support'];?></a>
                        </li>
                        <li>
                            <a href="#" id='signIn'><?php echo $STR['SignIn'];?></a>
                        </li>
                    </ul>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
</header>