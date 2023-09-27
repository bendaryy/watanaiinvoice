<?php

use App\Http\Controllers\ApisettingController as apisetting;
use App\Http\Controllers\CategoryController as category;
use App\Http\Controllers\CompanyController as company;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerController as customer;
use App\Http\Controllers\DocumentController as document;
use App\Http\Controllers\ImportController as import;
use App\Http\Controllers\IssureController as issure;
use App\Http\Controllers\MainController as main;
use App\Http\Controllers\manageDoucumentController;
use App\Http\Controllers\notificationController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\ProductsController as products;
use App\Http\Controllers\ProfileController as profile;
use App\Http\Controllers\RemoteController as remote;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ], function () {

        Auth::routes(['register' => false]);

        Route::group(['middleware' => ['auth']], function () {

            Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

            Route::resource('setting', apisetting::class);

            Route::resource('company', company::class);

            Route::resource('products', products::class);

            Route::resource('customer', customer::class);

            Route::resource('issure', issure::class);

            Route::post('savecustomer', [customer::class, 'savecustomer'])->name('savecustomer');

            Route::get('profile', [profile::class, 'index'])->name('profile');

            Route::post('updateprofile', [profile::class, 'update'])->name('updateprofile');

            Route::get('updatemypassword', [profile::class, 'password'])->name('updatemypassword');

            Route::post('updatepassword', [profile::class, 'updatePassword'])->name('updatepassword');

            Route::get('submit', [products::class, 'submit'])->name('submit');

            Route::post('sendproducts', [products::class, 'sendproducts'])->name('sendproducts');

            Route::get('rejected', [products::class, 'rejected'])->name('rejected');

            Route::get('active', [products::class, 'active'])->name('active');

            Route::post('getcategory', [category::class, 'getcategory'])->name('getcategory');

// Imports

            Route::get('import', [import::class, 'index'])->name('import');

            Route::post('categoryimport', [import::class, 'categoryimport'])->name('categoryimport');

// Portal

            Route::get('notifications', [main::class, 'notifications'])->name('notifications');

            Route::get('connection', [main::class, 'index'])->name('connection');

// Document

            Route::resource('document', document::class);

            Route::post('getproduct', [document::class, 'getproduct'])->name('getproduct');

            Route::post('gettaxtype', [document::class, 'gettaxtype'])->name('gettaxtype');

            Route::post('storeproduct', [document::class, 'storeproduct'])->name('storeproduct');

            Route::get('cancelorder/{id}', [document::class, 'cancelorder'])->name('cancelorder');

            Route::get('deleteproduct/{id}', [document::class, 'deleteproduct'])->name('deleteproduct');

            Route::post('updatorderdata', [document::class, 'updatorderdata'])->name('updatorderdata');

            Route::post('finish/{id}', [document::class, 'finish'])->name('document.finish');

            Route::get('notsubmitted', [document::class, 'notsubmitted'])->name('notsubmitted');

            Route::get('submitorder/{id}', [document::class, 'submitorder'])->name('submitorder');

// Seeds

            Route::get('taxx', [main::class, 'taxx'])->name('taxx');

            Route::get('activity', [main::class, 'activity'])->name('activity');

            Route::get('unittype', [main::class, 'unittype'])->name('unittype');

            Route::get('country', [main::class, 'country'])->name('country');

            Route::get('nontaxx', [main::class, 'nontaxx'])->name('notaxx');
            // show all invoices

            // Route::get('allInvoices/{id}', [manageDoucumentController::class, 'allInvoices'])->name('allinvoices')->middleware('auth');

// all invoice status

            Route::get('sentInvoices/{id}', [manageDoucumentController::class, 'sentInvoices'])->name('sentInvoices')->middleware('auth');
            Route::get('receivedInvoices/{id}', [manageDoucumentController::class, 'receivedInvoices'])->name('receivedInvoices')->middleware('auth');
            Route::get('createInvoice', [manageDoucumentController::class, 'createInvoice'])->name('createInvoice')->middleware('auth');
            Route::get('createInvoice/create2', [manageDoucumentController::class, 'createInvoice2'])->name('createInvoice2')->middleware('auth');
            Route::get('createInvoiceDollar', [manageDoucumentController::class, 'createInvoiceDollar'])->name('createInvoiceDollar')->middleware('auth');
            Route::get('createInvoiceDollar2', [manageDoucumentController::class, 'createInvoiceDollar2'])->name('createInvoiceDollar2')->middleware('auth');
            Route::get('testInvoice', [manageDoucumentController::class, 'createInvoice3'])->name('createInvoice3')->middleware('auth');
            Route::get('testInvoice/test2', [manageDoucumentController::class, 'createInvoice4'])->name('createInvoice4')->middleware('auth');

// send invoice
            Route::post('storeInvoice', [manageDoucumentController::class, 'invoice'])->name('storeInvoice')->middleware('auth');
            Route::post('storeInvoiceDollar', [manageDoucumentController::class, 'invoiceDollar'])->name('storeInvoiceDollar')->middleware('auth');

//signature
            Route::get('cer', [manageDoucumentController::class, 'openBat'])->name('cer')->middleware('auth');

// show pdf

            Route::get('showPdf/{uuid}', [manageDoucumentController::class, 'showPdfInvoice'])->name('pdf')->middleware('auth');
            Route::get('showPdfEnglish/{uuid}', [manageDoucumentController::class, 'showPdfInvoiceEnglish'])->name('pdfEnglish')->middleware('auth');

// for cancel sent invoices
            Route::put('cancelDocument/{uuid}', [manageDoucumentController::class, 'cancelDocument'])->name('cancelDocument')->middleware('auth');

// for reject recived invoices
            Route::put('rejectDocument/{uuid}', [manageDoucumentController::class, 'RejectDocument'])->name('RejectDocument')->middleware('auth');
            Route::get('pending', [products::class, 'pending'])->name('pending')->middleware('auth');

            Route::get('add-package', [PackagesController::class, 'addFullPackage'])->name('addFullPackage')->middleware('auth');
            Route::get('add-package-summary', [PackagesController::class, 'addSummaryPackage'])->name('addPackageSummary')->middleware('auth');

            Route::post('add-sendPackage-full', [PackagesController::class, 'sendFullPackage'])->name('sendFullPackage')->middleware('auth');
            Route::post('add-sendPackage-summary', [PackagesController::class, 'sendSummaryPackage'])->name('sendSummaryPackage')->middleware('auth');
            Route::get('allPackages', [PackagesController::class, 'showAllPackages'])->name('showAllPackages')->middleware('auth');
            Route::get('downloadPackage/{id}', [PackagesController::class, 'downloadPackage'])->name('downloadPackage')->middleware('auth');
            Route::get('notification', [notificationController::class, 'getNotifications'])->name('getNotifications')->middleware('auth');
            // Route::get('getNotificationsDashboard', [notificationController::class, 'getNotificationsDashboard'])->name('getNotificationsDashboard');
            Route::get('livewire', function () {
                return view('invoices.testlivewire');
            });

            // حالات الفواتير من خلالنا و من خلال العملاء
            Route::get('RequestcancelledDoc/{id}', [manageDoucumentController::class, 'RequestcancelledDoc'])->name('RequestCancell')->middleware('auth');
            Route::get('CompaniesRequestcancelledDoc/{id}', [manageDoucumentController::class, 'companiesRequestcancelledDoc'])->name('CompaniesRequestCancell')->middleware('auth');
            Route::get('cancelleddoc/{id}', [manageDoucumentController::class, 'cancelledDoc'])->name('allCancell')->middleware('auth');
            Route::get('companyCancelleddoc/{id}', [manageDoucumentController::class, 'companyCancelledDoc'])->name('companyAllCancell')->middleware('auth');
            Route::get('rejected/{id}', [manageDoucumentController::class, 'rejected'])->name('allRejected')->middleware('auth');
            Route::get('companyrejected/{id}', [manageDoucumentController::class, 'companyRejected'])->name('companyRejected')->middleware('auth');
            Route::get('requestcompanyrejected/{id}', [manageDoucumentController::class, 'requestCompanyRejected'])->name('requestCompanyRejected')->middleware('auth');
            Route::get('requestRejected/{id}', [manageDoucumentController::class, 'requestRejected'])->name('requestRejected')->middleware('auth');
            Route::put('DeclineRejectDocument/{uuid}', [manageDoucumentController::class, 'DeclineRejectDocument'])->name('declineRejectDocument')->middleware('auth');
            Route::put('DeclineCancelDocument/{uuid}', [manageDoucumentController::class, 'DeclineCancelDocument'])->name('declineCancellDocument')->middleware('auth');

            // show all invoices

            Route::get('allInvoices', [manageDoucumentController::class, 'allInvoices'])->name('allinvoices')->middleware('auth');

            Route::get('searchAll', function () {
                return view('invoices.allinvoices');
            })->name('searchAll');

        });

    });

// get company api
Route::get('getcompany/{id}', [CustomerController::class, 'getCompany'])->name('getCompany')->middleware('auth');

// Remote Server
Route::get('updatestatus', [remote::class, 'updatestatus'])->name('updatestatus')->middleware('auth');

// draft
route::post('draft', [manageDoucumentController::class, 'draft'])->name('draft')->middleware('auth');
route::post('draftDollar', [manageDoucumentController::class, 'draftDollar'])->name('draftDollar')->middleware('auth');
route::get('alldraft', [manageDoucumentController::class, 'showDraft'])->name('showDraft')->middleware('auth');
route::post('sendDraft/{id}', [manageDoucumentController::class, 'sendDraftData'])->name('sendDraftData')->middleware('auth');
route::get('showdetalils/{id}', [manageDoucumentController::class, 'showDraftDetails'])->name('showDraftDetails')->middleware('auth');
route::delete('deletedraft/{id}', [manageDoucumentController::class, 'deleteDraft'])->name('deleteDraft')->middleware('auth');

//sent
route::get('sentofdraft', [manageDoucumentController::class, 'SentInvoicesFromDraft'])->name('sentofdraft')->middleware('auth');
route::get('searchInSentInv', [manageDoucumentController::class, 'searchInSentInv'])->name('searchInSentInv')->middleware('auth');
route::get('showsentdetails/{uuid}', [manageDoucumentController::class, 'showSentInvDetails'])->name('showsentdetails')->middleware('auth');
route::delete('deletesent/{id}', [manageDoucumentController::class, 'deleteSentInv'])->name('deleteSentInv')->middleware('auth');
