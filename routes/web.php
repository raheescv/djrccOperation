<?php
use App\Http\Middleware\StartSession;
use App\Http\Middleware\Auditing;
use App\Http\Middleware\ActivityLog;
Route::get('SignUp'             , 'UsersController@SignUp')->name('SignUp');
Route::get('SignIn'             , 'UsersController@SignIn')->name('SignIn');
Route::post('Login'             , 'UsersController@Login')->name('Login');
Route::get('PasswordChange/{id}', 'UsersController@PasswordChange')->name('PasswordChange');
Route::put('PasswordReset/{id}' , 'UsersController@PasswordReset');
Route::post('check_email_exists','UsersController@check_email_exists')->name('check_email_exists');
Route::post('ForgotPasswordMail','UsersController@ForgotPasswordMail')->name('ForgotPasswordMail');
Route::post('Register'          , 'UsersController@Register')->name('Register');

Route::get('sendbasicemail'     ,'MailController@basic_email');
Route::get('sendhtmlemail'      ,'MailController@html_email');
Route::get('sendattachmentemail','MailController@attachment_email');


Route::group(['middleware' => [
	StartSession::class,
	// Auditing::class,
	// ActivityLog::class
	]], function () {
		Route::get('/'            , 'HomeController@home')->name('home');
		Route::get('/Empty'       , 'HomeController@EmptyPage')->name('empty');
		Route::get('lang/{locale}', 'HomeController@lang');

		Route::get('BackupDB'        , 'HomeController@BackupDB');
		Route::get('Download'        , 'HomeController@Download');
		Route::post('BackupTable'    , 'HomeController@BackupTable');
		Route::get('getFile/{id}'    , 'HomeController@getFile');
		Route::get('deleteFile/{id}' , 'HomeController@deleteFile');

		Route::resource('Users'         , 'UsersController');
		Route::get('Logout'             , 'UsersController@Logout')->name('Logout');
		Route::get('User/{id}'          , 'UsersController@User')->name('User');
		Route::post('AddUser'           , 'UsersController@AddUser')->name('AddUser');
		Route::get('getUser/{id}'       , 'UsersController@getUser')->name('getUser');
		Route::post('UpdateUser/{id}'   , 'UsersController@UpdateUser')->name('UpdateUser');
		Route::post('UpdateUserPassword', 'UsersController@UpdateUserPassword')->name('UpdateUserPassword');
		Route::put('UserPassword/Change/{id}', 'UsersController@UpdateUserPasswordById')->name('UpdateUserPasswordById');
		Route::get('CompanyProfile'     , 'UsersController@Profile')->name('CompanyProfile');
		Route::get('UserList'           , 'UsersController@Lists')->name('UserList');
		Route::get('/profile'           , 'UsersController@profile')->name('profile');
		Route::post('/profile_update'   , 'UsersController@profile_update')->name('profile_update');
		Route::post('SendMail'          , 'UsersController@SendMail')->name('SendMail');

		Route::get('UserTypePrivileges'      , 'UsersController@UserTypePrivileges');
		Route::post('Privilages_change_ajax' , 'UsersController@Privilages_change_ajax');
		Route::post('UserTypePrivilegesTable', 'UsersController@UserTypePrivileges_Table_ajax')->name('UserTypePrivilegesTable');

		Route::get('UserTypes'             , 'UsersController@UserTypes');
		Route::post('UserTypeTable'        , 'UsersController@UserType_Table_ajax')->name('UserTypeTable');
		Route::post('UserType/Store'       , 'UsersController@UserType_store_ajax')->name('UserType_store_ajax');
		Route::post('UserType/Update/{id}' , 'UsersController@UserType_update_ajax')->name('UserType_update_ajax');
		Route::get('UserType/delete/{id}'  , 'UsersController@UserType_destroy_ajax');

		Route::resource('Reminders'         , 'RemindersController');
		Route::post('reminder_data_ajax'    , 'RemindersController@index_ajax')->name('reminder_data_ajax');
		Route::post('reminder_store_ajax'   , 'RemindersController@reminder_store_ajax')->name('reminder_store_ajax');
		Route::get('/reminders/delete/{id}' , 'RemindersController@destroy_ajax');

		Route::resource('tasks'      , 'TasksController');
		Route::get('Calender'        , 'TasksController@index');
		Route::get('Tasks'           , 'TasksController@Tasks');
		Route::post('TaskTable'      , 'TasksController@Task_Table_ajax')->name('TaskTable');
		Route::post('add_Task'       , 'TasksController@add_Task_ajax');
		Route::get('get_Task/{id}'   , 'TasksController@get_Task_ajax');
		Route::post('edit_Task/{id}' , 'TasksController@edit_Task_ajax');
		Route::get('delete_Task/{id}', 'TasksController@delete_Task_ajax');

		Route::get('Settings'         , 'SettingsController@Settings');
		Route::post('Settings_Update' , 'SettingsController@Settings_Update');

		Route::get('Employee'             , 'EmployeeController@Employee');
		Route::post('EmployeeTable'       , 'EmployeeController@EmployeeTable')->name('EmployeeTable');
		Route::post('Employee/Store'      , 'EmployeeController@Employee_store_ajax')->name('Employee_store');
		Route::get('Employee/Get/{id}'    , 'EmployeeController@Employee_get_ajax');
		Route::post('Employee/Update/{id}', 'EmployeeController@Employee_update_ajax')->name('Employee_update');
		Route::get('Employee/Delete/{id}' , 'EmployeeController@Employee_destroy_ajax');
		Route::post('Employee/GetList'    , 'EmployeeController@Employee_get_list_ajax');

		Route::post('Employee_name_check','EmployeeController@Employee_name_check')->name('Employee_name_check');
		Route::post('Employee_employee_code_check','EmployeeController@Employee_employee_code_check')->name('Employee_employee_code_check');
		Route::post('Employee_company_code_check','EmployeeController@Employee_company_code_check')->name('Employee_company_code_check');

		Route::get('DocumentType'             , 'SettingsController@DocumentType');
		Route::post('DocumentTypeTable'       , 'SettingsController@DocumentTypeTable')->name('DocumentTypeTable');
		Route::post('DocumentType/Store'      , 'SettingsController@DocumentType_store_ajax')->name('DocumentType_store');
		Route::get('DocumentType/Get/{id}'    , 'SettingsController@DocumentType_get_ajax');
		Route::post('DocumentType/Update/{id}', 'SettingsController@DocumentType_update_ajax')->name('DocumentType_update');
		Route::get('DocumentType/Delete/{id}' , 'SettingsController@DocumentType_destroy_ajax');
		Route::post('DocumentType/GetList'    , 'SettingsController@DocumentType_get_list_ajax');

		Route::get('Document'             , 'EmployeeController@Document');
		Route::post('DocumentTable'       , 'EmployeeController@DocumentTable')->name('DocumentTable');
		Route::post('Document/Store'      , 'EmployeeController@Document_store_ajax')->name('Document_store');
		Route::get('Document/Get/{id}'    , 'EmployeeController@Document_get_ajax');
		Route::post('Document/Update/{id}', 'EmployeeController@Document_update_ajax')->name('Document_update');
		Route::get('Document/Delete/{id}' , 'EmployeeController@Document_destroy_ajax');

		Route::get('Country'             , 'SettingsController@Country');
		Route::post('CountryTable'       , 'SettingsController@CountryTable')->name('CountryTable');
		Route::post('Country/Store'      , 'SettingsController@Country_store_ajax')->name('Country_store');
		Route::get('Country/Get/{id}'    , 'SettingsController@Country_get_ajax');
		Route::post('Country/Update/{id}', 'SettingsController@Country_update_ajax')->name('Country_update');
		Route::get('Country/Delete/{id}' , 'SettingsController@Country_destroy_ajax');

		Route::get('Beacons'            , 'BeaconController@Beacons');
		Route::get('TestBeacons'        , 'BeaconController@TestBeacons');
		Route::get('Beacon'             , 'BeaconController@Beacon');
		Route::get('Beacon/{id}'        , 'BeaconController@Beacon');
		Route::get('TestBeacon'         , 'BeaconController@TestBeacon');
		Route::get('TestBeacon/{id}'    , 'BeaconController@TestBeacon');
		Route::get('BeaconView/{id}'    , 'BeaconController@BeaconView');
		Route::post('BeaconTable'       , 'BeaconController@BeaconTable')->name('BeaconTable');
		Route::post('Beacon/Store'      , 'BeaconController@Beacon_store')->name('Beacon_store');
		Route::post('Beacon/Update/{id}', 'BeaconController@Beacon_update')->name('Beacon_update');
		Route::get('Beacon/Delete/{id}' , 'BeaconController@Beacon_destroy_ajax');
		Route::post('Beacon/GetList'    , 'BeaconController@Beacon_get_list_ajax');

		Route::get('Log'             , 'LogController@Log');
		Route::post('LogTable'       , 'LogController@LogTable')->name('LogTable');
		Route::post('Log/Store'      , 'LogController@Log_store_ajax')->name('Log_store');
		Route::get('Log/Print/{id}'  , 'LogController@Log_Print');
		Route::get('Log/Get/{id}'    , 'LogController@Log_get_ajax');
		Route::post('Log/Update/{id}', 'LogController@Log_update_ajax')->name('Log_update');
		Route::get('Log/Delete/{id}' , 'LogController@Log_destroy_ajax');
		
		Route::get('Schedule'             , 'EmployeeController@Schedule');
		Route::post('ScheduleTable'       , 'EmployeeController@ScheduleTable')->name('ScheduleTable');
		Route::post('Schedule/Store'      , 'EmployeeController@Schedule_store_ajax')->name('Schedule_store');
		Route::get('Schedule/Print/{ids}' , 'EmployeeController@Schedule_Print');
		Route::get('Schedule/Get/{id}'    , 'EmployeeController@Schedule_get_ajax');
		Route::post('Schedule/Update/{id}', 'EmployeeController@Schedule_update_ajax')->name('Schedule_update');
		Route::get('Schedule/Delete/{id}' , 'EmployeeController@Schedule_destroy_ajax');

		Route::get('CheckList'             , 'CheckListController@CheckList');
		Route::post('CheckListTable'       , 'CheckListController@CheckListTable')->name('CheckListTable');
		Route::post('CheckList/Store'      , 'CheckListController@CheckList_store_ajax')->name('CheckList_store');
		Route::get('CheckList/Print/{id}'  , 'CheckListController@CheckList_Print');
		Route::get('CheckList/Get/{id}'    , 'CheckListController@CheckList_get_ajax');
		Route::post('CheckList/Update/{id}', 'CheckListController@CheckList_update_ajax')->name('CheckList_update');
		Route::get('CheckList/Delete/{id}' , 'CheckListController@CheckList_destroy_ajax');

		Route::get('Situations'            , 'SituationController@Situations');
		Route::get('Situation'             , 'SituationController@Situation');
		Route::get('Situation/{id}'        , 'SituationController@Situation');
		Route::get('Situation/Print/{id}'  , 'SituationController@Situation_Print');
		Route::post('SituationTable'       , 'SituationController@SituationTable')->name('SituationTable');
		Route::post('Situation/Store'      , 'SituationController@Situation_store')->name('Situation_store');
		Route::post('Situation/Store/{id}' , 'SituationController@Situation_update')->name('Situation_update');
		Route::get('Situation/Delete/{id}' , 'SituationController@Situation_destroy_ajax');

		Route::post('SituationDetailTable'       , 'SituationController@SituationDetailTable')->name('SituationDetailTable');
		Route::post('SituationDetail/Store'      , 'SituationController@SituationDetail_store_ajax')->name('SituationDetail_store');
		Route::get('SituationDetail/Delete/{id}' , 'SituationController@SituationDetail_destroy_ajax');
	});
