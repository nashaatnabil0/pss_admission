<?php
  $Urole=$_SESSION['role'];
?>


<aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <li class="active" >
            <a class="" href="dashboard.php">
              <i class="icon_house_alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_desktop"></i>
                          <span>Seasons</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="add_season.php">Add Season</a></li>
              <li><a class="" href="viewall_seasons.php">Manage Seasons</a></li>
             
            </ul>
          </li>
                <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_document_alt"></i>
                          <span>Sports</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="add_sport.php">Add Sport</a></li>
              <li><a class="" href="viewall_sports.php">Manage Sports</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_document_alt"></i>
                          <span>Trainers</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="add_trainer.php">Add Trainer</a></li>
              <li><a class="" href="viewall_trainers.php">Manage Trainers</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_document_alt"></i>
                          <span>Trainees</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="add_trainee.php">Add Trainee</a></li>
              <li><a class="" href="viewall_trainees.php">Manage Trainees</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_table"></i>
                          <span>Groups</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="add_group.php">Add Group</a></li>
              <li><a class="" href="viewall_groups.php">Manage Groups</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_table"></i>
                          <span>Enrollment</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="add_enrollment.php">Add Enrollment</a></li>
              <li><a class="" href="viewall_enrollments.php">Manage Enrollments</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_table"></i>
                          <span>Payment</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="make_payment.php">Add Payment</a></li>
              <li><a class="" href="viewall_payments.php">Manage Payments</a></li>
            </ul>
          </li>
          <li>
            <a class="" href="search.php">
              <i class="icon_genius"></i>
              <span>Search </span>
            </a>
          </li>
          
          <?php if($Urole == 'admin'): ?>
          <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="icon_documents_alt"></i>
              <span>Users</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
              <ul class="sub">
                <li><a class="" href="add_user.php"><span>Add User</span></a></li>
                <li><a class="" href="Viewall_users.php"><span>Manage Users</span></a></li>
              </ul>
          </li>
          <?php endif; ?>

          <!--<li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_documents_alt"></i>
                          <span>Pages</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="aboutus.php"><span>About Us</span></a></li>
              <li><a class="" href="contactus.php"><span>Contact Us</span></a></li>
            </ul>
          </li>-->
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>