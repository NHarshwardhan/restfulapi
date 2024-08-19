<?php
require '../../vendor/autoload.php';

require './user_service.php';


   // use PHPUnit\Framework\Assert;
   // // use Mockery;
   // // use PHPUnit\Framework\Assert as Assert;

   // function testGetUserServiceWithMock(){

   //     $userRespositoryMock =  Mockery::mock('alias:UserRepository');
   //     $userRespositoryMock->shouldReceive('findUserById')
   //                            ->with(1)
   //                               ->andReturn(['id'=>1, 'name'=>'John Doe']);
      
   //    $user = getUserService(1);

   // //    $expected = ['id'=>1, 'name'=>'John Doe'];
   // //    echo 'expected: '.print_r($expected, true)."\n";
   // //    echo 'Actual: '.print_r($user, true)."\n";

   //    Assert::assertEquals(['id'=>1, 'name'=>'John Doe'],$user);

   
   // }

   // function testCreateUserServiceWithMock(){

   //     $userRespositoryMock =  Mockery::mock('alias:UserRepository');
   //     $userRespositoryMock->shouldReceive('insertUser')
   //                            ->with('Alice Brown')
   //                               ->andReturn(['id'=>3, 'name'=>'Alice Brown']);
      
   //    $user = createUserService('Alice Brown');
   // //    $expected = ['id'=>3, 'name'=>'Alice Brown'];

   // //    echo 'expected: '.print_r($expected, true)."\n";
   // //    echo 'Actual: '.print_r($user, true)."\n";

   //    Assert::assertEquals(['id'=>3, 'name'=>'Alice Brown'],$user);

   
   // }

   // function testUpdateUserServiceWithMock(){

   //     $userRespositoryMock =  Mockery::mock('alias:UserRepository');
   //     $userRespositoryMock->shouldReceive('updateUserbyId')
   //                            ->with(1,'Peter Parker')
   //                               ->andReturn(['id'=>1, 'name'=>'Peter Parker']);
      
   //    $user = updateUserService(1,'Peter Parker');
   // //    $expected = ['id'=>3, 'name'=>'Alice Brown'];

   // //    echo 'expected: '.print_r($expected, true)."\n";
   // //    echo 'Actual: '.print_r($user, true)."\n";

   //    Assert::assertEquals(['id'=>1, 'name'=>'Peter Parker'],$user);

   
   // }

   // function testDeleteUserServiceWithMock(){

   //     $userRespositoryMock =  Mockery::mock('alias:UserRepository');
   //     $userRespositoryMock->shouldReceive('deleteUserbyId')
   //                            ->with(1)
   //                               ->andReturn(true);
      
   //    $result = deleteUserService(1);
   // //    $expected = ['id'=>3, 'name'=>'Alice Brown'];

   // //    echo 'expected: '.print_r($expected, true)."\n";
   // //    echo 'Actual: '.print_r($user, true)."\n";

   //    Assert::assertTrue($result);

   
   // }


   // function runAllTests(){
   //     testGetUserServiceWithMock();
   //     testCreateUserServiceWithMock();
   //     testUpdateUserServiceWithMock();
   //     testDeleteUserServiceWithMock();
   // }


   // runAllTests();

   // Mockery::close();
   // echo 'All Test Passed';


   // ----------------------------------------------------------
   

?>