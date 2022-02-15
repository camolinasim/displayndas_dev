<?php

    //*************************************************************
    // Key and value pairs used for $_SESSION based access control
    //
    //  _key is the $_SESSION array key (index)
    //  _val is the $_SESSION array value (element)
    //
    // Note (09.03.13)
    //   Change these so that another application doesnt inadvertently give access to this one

  $prefix = "MILESTONES";

    // As of 04.10.13, Specific value is set by the login processing script
  $userAuthenticationID_key    = "${prefix}_ID";
  $userAuthenticationID_val    = "";

    // As of 04.10.13, set by the login processing script to default value
  $userAuthenticationAuth_key  = "${prefix}_AUTHENTICATION";
  $userAuthenticationAuth_val  = "AUTHENTICATED";

  //  Use these variables to give admin access to certain users
  $userAuthenticationAdmin_key  = "${prefix}_ADMIN";
  $userAuthenticationAdmin_val  = false;  //Initially set to false, updated to true after verification


?>
