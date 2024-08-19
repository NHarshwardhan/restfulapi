<?php

use PHPUnit\Framework\Assert;

require '../../vendor/autoload.php';

require './user_service.php';
require './data.php';

function setUp(){
    global $users;

    $users = [
      1=>['id'=>1, 'name'=>'John Doe'],
      2 =>['id'=>2, 'name'=>'Jane Smith']
   ];
}


function testGetUserServiceIntegration() {

    setUp();
    $user = getUserService(1);
    Assert::assertEquals(['id'=>1,'name'=>'John Doe'],$user);
    

}

function testCreateUserServiceIntegration() {
   setUp();
   $user = createUserService('Alice Brown');
   Assert::assertEquals(['id'=>3,'name'=>'Alice Brown'],$user);
}

function testUpdateUserServiceIntegration() {
   setUp();
   $user = updateUserService(1, 'John Updated');
   Assert::assertEquals(['id'=>1,'name'=>'John Updated'],$user);
}

function testDeleteUserServiceIntegration() {

   setUp();
   $result = deleteUserService(1);
   Assert::assertTrue($result);

   $deletedUser = getUserService(1);
   Assert::assertNull($deletedUser);
}


function runAllTests()
{
   testGetUserServiceIntegration();
   testCreateUserServiceIntegration();
   testUpdateUserServiceIntegration();
   testDeleteUserServiceIntegration();
}


runAllTests();


echo 'All Test Passed';

?>