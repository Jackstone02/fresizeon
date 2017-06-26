<?php
/*
 * Codecanyon
 * Name:Ajay Kumar choudhary
 * Email:ajay@froiden.com
 */

# Employee Login
    Route::get('/',['as'=>'login','uses'=>'LoginController@index']);
    Route::post('/login',['as'=>'login','uses'=>'LoginController@ajaxLogin']);
    Route::get('logout', ['as'=>'front.logout','uses'=>'LoginController@logout']);

# Employee Panel After Login
Route::group(array('before' => 'auth.employees'), function()
{
    Route::post('/change_password_modal',['as'=>'front.change_password_modal','uses'=>'DashboardController@changePasswordModal']);
    Route::post('/change_password',['as'=>'front.change_password','uses'=>'DashboardController@change_password']);
    Route::get('ajaxApplications/{$id}',['as'=>'front.leave_applications','uses'=> 'DashboardController@ajaxApplications']);

    Route::get('leave',['as'=>'front.leave','uses'=>'DashboardController@leave']);

    Route::post('dashboard/notice/{id}',['as'=>'front.notice_ajax','uses'=>'DashboardController@notice_ajax']);

    Route::post('leave_store',['as'=>'front.leave_store','uses'=>'DashboardController@leave_store']);

    Route::resource('dashboard','DashboardController');
});


# Admin Login
Route::group(array('prefix' => 'admin'), function()
{

	Route::get('/',['as'=>'admin.getlogin','uses'=>'AdminLoginController@index']);
	Route::get('logout',['as'=>'admin.logout','uses'=> 'AdminLoginController@logout']);

    Route::post('login',['as'=>'admin.login','uses'=> 'AdminLoginController@ajaxAdminLogin']);

});


// Admin Panel After Login
Route::group(array('prefix' => 'admin','before' => 'auth.admin|lock'), function()
{

    //	Dashboard Routing
    //Route::resource('dashboard', 'AdminDashboardController');
    Route::resource('dashboard', 'AdminDashboardController',['as' => 'admin']);

    //    Employees Routing
	Route::get('employees/export',['as'=>'admin.employees.export','uses'=>'EmployeesController@export']);
    Route::get('employees/employeeLogin/{id}',['as'=>'admin.employees.employeeLogin','uses'=>'EmployeesController@employeesLogin']);
    Route::resource('employees', 'EmployeesController',['except' => ['show'],'as' => 'admin']);

     //    Payslip List Routing --jack 12.02.2016
    Route::get('payslip/filter',['as'=>'admin.payslip.filter','uses'=>'PayslipController@filter']);
    Route::get('payslip/individualPay/{employeeID}/{year}/{month}/{pay}',['as'=>'admin.payslip.individualPay','uses'=>'PayslipController@individualPay']);
    Route::get('payslip/export',['as'=>'admin.payslip.export','uses'=> 'PayslipController@export']); 
    Route::get('payslip/exportPayslips',['as'=>'admin.payslip.exportPayslips','uses'=> 'PayslipController@exportPayslips']); 
    Route::get('payslip/exporting',['as'=>'admin.payslip.exporting','uses'=>'PayslipController@exporting']);  

    Route::get('ajax_payslip/',['as'=>'admin.ajax_payslip','uses'=> 'PayslipController@ajax_payslip']);
    Route::resource('payslip', 'PayslipController',['except' => ['show'],'as' => 'admin']);

    /*
    //  Overtime Routing
    Route::get('ajax_overtime/',['as'=>'admin.ajax_overtime','uses'=> 'OvertimeController@ajax_overtime']);
    Route::resource('overtime', 'OvertimeController',['except'=>['show'],'as' => 'admin']);
    */

    //  Awards Routing
    Route::get('ajax_awards/',['as'=>'admin.ajax_awards','uses'=> 'AwardsController@ajax_awards']);
    Route::resource('awards', 'AwardsController',['except'=>['show'],'as' => 'admin']);

    //  Deductions Routing
    Route::get('ajax_deductions/',['as'=>'admin.ajax_deductions','uses'=> 'DeductionsController@ajax_deductions']);
    Route::resource('deductions', 'DeductionsController',['except'=>['show'],'as' => 'admin']);

    //  Department Routing
    Route::get('departments/ajax_designation/',['as'=>'admin.departments.ajax_designation','uses'=> 'DepartmentsController@ajax_designation']);
    Route::get('departments/members/{id}',['as'=>'admin.departments.members','uses'=> 'DepartmentsController@members']);
    Route::resource('departments', 'DepartmentsController',['except' => ['show','create'],'as' => 'admin']);

    //    Expense Routing
    Route::get('expenses/filter',['as'=>'admin.expenses.filter','uses'=>'ExpensesController@filter']);
    Route::get('ajax_expenses/',['as'=>'admin.ajax_expenses','uses'=> 'ExpensesController@ajax_expenses']);
    Route::resource('expenses', 'ExpensesController',['except' => ['show'],'as' => 'admin']);

    //    Project Expense Routing
    Route::get('projectexpenses/project',['as'=>'admin.projectexpenses.filter','uses'=>'ProjectExpensesController@filter']);
    Route::get('ajax_projectexpenses/',['as'=>'admin.ajax_projectexpenses','uses'=> 'ProjectExpensesController@ajax_projectexpenses']);
    Route::resource('projectexpenses', 'ProjectExpensesController',['except' => ['show'],'as' => 'admin']);

    //    Reports
    //Route::resource('reports', 'ReportsController',['as' => 'admin']);
   // Route::resource('overall', 'ReportsController',['as' => 'admin']);

    Route::get('reports/overall',['as'=>'admin.reports.overall','uses'=>'ReportsController@overall']);
    Route::resource('reports', 'ReportsController',['except' => ['show'],'as' => 'admin']);

    //    Holiday Routing
    Route::get('holidays/mark_sunday', 'HolidaysController@Sunday');
    Route::resource('holidays', 'HolidaysController',['as' => 'admin']);

    //  Routing for the attendance
    Route::get('attendances/report/{attendances}', ['as'=>'admin.attendance.report','uses'=>'AttendancesController@report']);
    Route::resource('attendances', 'AttendancesController',['as' => 'admin']);

    //    Routing or the leavetypes
    Route::resource('leavetypes', 'LeavetypesController',['except'=>['show'],'as' => 'admin']);

    //    Leave Applications routing
    Route::get('leave_applications/ajaxApplications',['as'=>'admin.leave_applications','uses'=> 'LeaveApplicationsController@ajaxApplications']);
    Route::resource('leave_applications', 'LeaveApplicationsController',['except'=>['create','store','edit'],'as' => 'admin']);

    //   Routing for setting
    Route::resource('settings', 'SettingsController',['only'=>['edit','update'],'as' => 'admin']);

    //    Salary Routing
    Route::resource('salary','SalaryController',['only'=>['destroy','update','store'],'as' => 'admin']);

    //    Profile Setting
    Route::resource('profile_settings', 'ProfileSettingsController',['only'=>['edit','update'],'as' => 'admin']);

    //   Notification Setting

	Route::post('ajax_update_notification',['as'=>'admin.ajax_update_notification','uses'=> 'NotificationSettingsController@ajax_update_notification']);
    Route::resource('notificationSettings', 'NotificationSettingsController',['only'=>['edit','update'],'as' => 'admin']);

    //  Notice Board
    Route::get('ajax_notices/',['as'=>'admin.ajax_notices','uses'=> 'NoticeboardsController@ajax_notices']);
    Route::resource('noticeboards', 'NoticeboardsController',['except'=>['show'],'as' => 'admin']);

});

// Lock Screen Routing
Route::get('screenlock', 'AdminDashboardController@screenlock');

//Event for updating the last login of user
Event::listen('auth.login', function($user)
{
    $user->last_login = new DateTime;
    $user->save();
});
