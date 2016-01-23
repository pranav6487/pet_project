<?php
global $global_params;
global $page_params;

$pageArgs = $global_params['page_arguments'];

if( $pageArgs['aj'] == 1 ) {
    if( $pageArgs['action'] == "login" ) {
        $users = new Users();
        $signIn = $users->signIn($pageArgs['loginEmail'],$pageArgs['loginPswd']);
        echo json_encode($signIn);
        exit;
    }

    if( $pageArgs['action'] == "forgotPasswd" ) {
        $users = new Users();
        $return = $users->forgotPasswd( $pageArgs['email'] );
        echo json_encode($return);
        exit;
    }
    
    if( $pageArgs['action'] == "resetPasswd" ) {
        $users = new Users();
        $return = $users->resetPasswd( $pageArgs );
        echo json_encode($return);
        exit;
    }
    
    if( $pageArgs['action'] == "logout" ) {
        $users = new Users();
        $return = $users->signOut();
        echo json_encode($return);
        exit;
    }
}
?>