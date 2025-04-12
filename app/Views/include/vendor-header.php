    <!--Nav-->
    <nav class="bg-gray-800 pt-12 md:pt-1 pb-1 px-1 mt-0 h-auto fixed w-full z-20 top-0">
        <div class="flex flex-wrap items-center">
            <div class="flex flex-shrink md:w-1/3 justify-center md:justify-start text-white">
                <a href="#">
                    <span class="text-xl pl-2"><?php echo $name;?></span>
                </a>
            </div>

            <div class="flex flex-1 md:w-1/3 justify-center md:justify-start text-white px-2">
                <span class="relative w-full">
                    <input type="search" class="w-full bg-gray-800 text-white transition border border-transparent focus:outline-none focus:border-gray-400 rounded py-3 px-2 pl-10 appearance-none leading-normal">
                    <!--<div class="absolute search-icon" style="top: 1rem; left: .8rem;">-->
                    <!--    <svg class="fill-current pointer-events-none text-white w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">-->
                    <!--        <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>-->
                    <!--    </svg>-->
                    <!--</div>-->
                </span>
            </div>

            <div class="flex w-full pt-2 content-center justify-between md:w-1/3 md:justify-end">
                <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                    <!--<li class="flex-1 md:flex-none md:mr-3">-->
                    <!--    <a class="inline-block py-2 px-4 text-white no-underline" href="#">Active</a>-->
                    <!--</li>-->
                    <!--<li class="flex-1 md:flex-none md:mr-3">-->
                    <!--    <a class="inline-block text-gray-600 no-underline hover:text-gray-200 hover:text-underline py-2 px-4" href="#">link</a>-->
                    <!--</li>-->
                    <li class="flex-1 md:flex-none md:mr-3">
                        <div class="relative inline-block">
                            <button onclick="toggleDD('myDropdown')" class="drop-button text-white focus:outline-none"> <span class="pr-2"><i class="em em-robot_face"></i></span> Hi, <?php echo $name;?> <svg class="h-3 fill-current inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg></button>
                            <div id="myDropdown" class="dropdownlist absolute bg-gray-800 text-white right-0 mt-3 p-3 overflow-auto z-30 invisible">
                                <!--<input type="text" class="drop-search p-2 text-gray-600" placeholder="Search.." id="myInput" onkeyup="filterDD('myDropdown','myInput')">-->
                                <?php 
                                $todaydate = Date('Y-m-d');
                                if($active!=0){
                                    if($expirydate > $todaydate){
                                        ?>
                                        <a href="<?php echo base_url('/index.php/vendor_profile_active');?>" class="p-2 hover:bg-gray-800 text-white text-sm    no-underline hover:no-underline block"><i class="fa fa-user fa-fw"></i>Vendor Profile</a>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <a href="<?php echo base_url('/index.php/vendor_profile');?>" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-user fa-fw"></i>Vendor Profile</a>
                                    <?php
                                }
                                ?>
                                <a href="<?php echo base_url('/index.php/vendor-change-password');?>" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-lock fa-fw"></i>Change Password</a>
                                <?php 
                                $bylogin_email=$session->get("bylogin_email");
                                if($bylogin_email!='')
                                {
                                    ?>
                                    <button class="dropdown-item" data-toggle="modal" data-target="#bd-example-modal-lg-DirectLogin-"><i class="mdi mdi-logout text-primary"></i>Back Self Login</button>
                                    <?php 
                                }
                                ?>
                                <!--<a href="#" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-cog fa-fw"></i> Settings</a>-->
                                <div class="border border-gray-800"></div>
                                <a href="<?php echo base_url('/index.php/vlogout');?>" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fas fa-sign-out-alt fa-fw"></i> LogOut</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
   <div class="flex flex-col md:flex-row">
        <?php 
        $todaydate = Date('Y-m-d');
        if($active!=0){
            if($expirydate > $todaydate){
            ?>
            <div class="bg-gray-800 shadow-xl h-16 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48">
                <div class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                    <ul class="list-reset flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">
                        <li class="mr-3 flex-1">
                            <a href="<?php echo base_url('/index.php/vendor-dashboard');?>" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500">
                                <i class="fas fa-tasks pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Dashboard</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1">
                            <a href="<?php echo base_url('/index.php/add-bill-vendor');?>" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                                <i class="fa fa-envelope pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Add Bill Draft</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1">
                            <a href="<?php echo base_url('/index.php/all-bill-mapping-vendor-list');?>" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600">
                                <i class="fas fa-chart-area pr-0 md:pr-3 text-blue-600"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Bill Status</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php } 
        }
        else{ ?>
            
        <?php }
        ?>
    