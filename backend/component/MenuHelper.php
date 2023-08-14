<?php

namespace backend\component;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\ebl\Constants as C;

class MenuHelper {

    public static $menu = [
        "dashboard" => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-home"],
            "items" => [
                'dashboard' => [
                    ['module' => '', 'controller' => 'site', 'action' => 'index', 'label' => 'Dashboard', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'site', 'action' => 'changes-password', 'label' => 'Change Password', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ]
            ]
        ],
        'user_management' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-users"],
            "items" => [
                'account' => [
                    ['module' => '', 'controller' => 'account', 'action' => 'index', 'label' => 'Account', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'view', 'label' => 'Account Detail', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'add', 'label' => 'Add Customer', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'update', 'label' => 'Update Customer', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'renewal', 'label' => 'Renew Account', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'addons', 'label' => 'Addon', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'modify', 'label' => 'Change Plan', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'susres', 'label' => 'Suspend/Resume', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'refresh', 'label' => 'Refresh', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'setting', 'label' => 'setting', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'terminate', 'label' => 'Disconnect', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'payment', 'label' => 'Payment', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'charges', 'label' => 'Charges', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'account', 'action' => 'complaint', 'label' => 'Raise Ticket', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ]
            ]
        ],
        "franchiseAccounting" => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-line-chart"],
            "items" => [
                "ledger" => [
                    ['module' => '', 'controller' => 'opt-accounting', 'action' => 'operator-ledger', 'label' => 'Ledger', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "collection" => [
                    ['module' => '', 'controller' => 'opt-accounting', 'action' => 'operator-collection', 'label' => 'Collections', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "optBalance" => [
                    ['module' => '', 'controller' => 'opt-accounting', 'action' => 'operator-balance', 'label' => 'Balance', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_RO, C::DESIG_DISTRIBUTOR]]
                ],
                "optCreditDebit" => [
                    ['module' => '', 'controller' => 'opt-accounting', 'action' => 'operator-creditdebit', 'label' => 'Credit/Debit Note', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "optBill" => [
                    ['module' => '', 'controller' => 'opt-accounting', 'action' => 'operator-bill', 'label' => 'Invoice', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'opt-accounting', 'action' => 'print-bill', 'label' => 'Invoice Print', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "deposit-instrument" => [
                    ['module' => '', 'controller' => 'opt-accounting', 'action' => 'deposit-instrument', 'label' => 'Deposit Instrument', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "reconcile-instrument" => [
                    ['module' => '', 'controller' => 'opt-accounting', 'action' => 'reconcile-instrument', 'label' => 'Reconcile Instrument', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "instrument-status" => [
                    ['module' => '', 'controller' => 'opt-accounting', 'action' => 'instrument-status', 'label' => 'Instrument Status', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
            ]
        ],
        "customerAccounting" => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa    fa-area-chart"],
            "items" => [
                "collection" => [
                    ['module' => '', 'controller' => 'cust-accounting', 'action' => 'collections', 'label' => 'Collection', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "transactions" => [
                    ['module' => '', 'controller' => 'cust-accounting', 'action' => 'transactions', 'label' => 'Raise Note', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "monthly-statement" => [
                    ['module' => '', 'controller' => 'cust-accounting', 'action' => 'monthly-statement', 'label' => 'Monthly Statement', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'cust-accounting', 'action' => 'print-statement', 'label' => 'Monthly Statement', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "subBill" => [
                    ['module' => '', 'controller' => 'cust-accounting', 'action' => 'customer-bill', 'label' => 'Invoice', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'cust-accounting', 'action' => 'print-bill', 'label' => 'Invoice Print', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "deposit-instrument" => [
                    ['module' => '', 'controller' => 'custaccounting', 'action' => 'deposit-instrument', 'label' => 'Deposit Instrument', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "reconcile-instrument" => [
                    ['module' => '', 'controller' => 'custaccounting', 'action' => 'reconcile-instrument', 'label' => 'Reconcile Instrument', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "instrument-status" => [
                    ['module' => '', 'controller' => 'custaccounting', 'action' => 'instrument-status', 'label' => 'Instrument Status', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
            ]
        ],
        "CRM" => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa  fa-ticket"],
            "items" => [
                "prospect" => [
                    ['module' => '', 'controller' => 'prospect', 'action' => 'index', 'label' => 'Prospect Dashboard', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'prospect', 'action' => 'add-prospect', 'label' => 'Add New Prospect', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'prospect', 'action' => 'process-request', 'label' => 'Prospect Request', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "complaint" => [
                    ['module' => '', 'controller' => 'complaint', 'action' => 'index', 'label' => 'Complaint', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'complaint', 'action' => 'add-complaint', 'label' => 'Add New Complaint', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'complaint', 'action' => 'process-complaint', 'label' => 'Process Ticket', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'complaint', 'action' => 'view-complaint', 'label' => 'Ticket Details', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ]
            ]
        ],
        'report' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-bar-chart"],
            "items" => [
                "active-customer" => [
                    ['module' => '', 'controller' => 'report', 'action' => 'active-customer', 'label' => 'Active Customer', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "inactive-customer" => [
                    ['module' => '', 'controller' => 'report', 'action' => 'inactive-customer', 'label' => 'In-Active Customer', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "expired-customer" => [
                    ['module' => '', 'controller' => 'report', 'action' => 'expired-customer', 'label' => 'Expired Customer', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "renewal" => [
                    ['module' => '', 'controller' => 'report', 'action' => 'renewal', 'label' => 'Renewal Details', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "complaint" => [
                    ['module' => '', 'controller' => 'report', 'action' => 'complaint', 'label' => 'Complaints', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "prospect" => [
                    ['module' => '', 'controller' => 'report', 'action' => 'prospect', 'label' => 'Prospect', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "plan-summary" => [
                    ['module' => '', 'controller' => 'report', 'action' => 'plan-summary', 'label' => 'Plan Summary', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "fran-plan" => [
                    ['module' => '', 'controller' => 'report', 'action' => 'fran-plan', 'label' => 'Franchise Vs Plan', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "fran-customer" => [
                    ['module' => '', 'controller' => 'report', 'action' => 'fran-customer', 'label' => 'Franchise Vs Customer', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
            ]
        ],
        'organization' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-sitemap"],
            "items" => [
                'regional_office' => [
                    ['module' => '', 'controller' => 'operator', 'action' => 'ro', 'label' => 'RO', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'add-ro', 'label' => 'Register RO', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'operator', 'action' => 'update-ro', 'label' => 'Update RO', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'view-ro', 'label' => 'View RO', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'recharge-ro', 'label' => 'Recharge', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'operator', 'action' => 'ro-online-recharge', 'label' => 'Online Recharge', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_RO]],
                ],
                'distributor' => [
                    ['module' => '', 'controller' => 'operator', 'action' => 'distributor', 'label' => 'Distributor', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'add-distributor', 'label' => 'Register Distributor', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'update-distributor', 'label' => 'Update Distributor', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'view-distributor', 'label' => 'View Distributor', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'recharge-distributor', 'label' => 'Recharge', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'dis-online-recharge', 'label' => 'Online Recharge', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_DISTRIBUTOR]],
                ],
                'franchise' => [
                    ['module' => '', 'controller' => 'operator', 'action' => 'franchise', 'label' => 'Franchise', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'add-franchise', 'label' => 'Register Franchise', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'update-franchise', 'label' => 'Update Franchise', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'view-franchise', 'label' => 'View Franchise', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'recharge-franchise', 'label' => 'Recharge', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'add-mrp', 'label' => 'Change Plans MRP', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'add-static-mrp', 'label' => 'Change Static Plan MRP', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'credit-debit', 'label' => 'Credit/Debit', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'operator', 'action' => 'fran-online-recharge', 'label' => 'Online Recharge', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR]],
                ],
            ]
        ],
        'employeeManagement' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-user-circle"],
            "items" => [
                "employee" => [
                    ['module' => '', 'controller' => 'site', 'action' => 'user', 'label' => 'Employee', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'site', 'action' => 'add-user', 'label' => 'Add User', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'site', 'action' => 'update-user', 'label' => 'Update User', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'site', 'action' => 'assign-operator', 'label' => 'Assign ' . C::OPERATOR_TYPE_LCO_NAME, 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ]
            ]
        ],
        'location' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-map-marker"],
            "items" => [
                'city' => [
                    ['module' => '', 'controller' => 'location', 'action' => 'city', 'label' => 'City', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'location', 'action' => 'add-city', 'label' => 'Add City', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'location', 'action' => 'update-city', 'label' => 'Update City', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'area' => [
                    ['module' => '', 'controller' => 'location', 'action' => 'area', 'label' => 'Area', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'location', 'action' => 'add-area', 'label' => 'Area', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'location', 'action' => 'update-area', 'label' => 'Update Area', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'road' => [
                    ['module' => '', 'controller' => 'location', 'action' => 'road', 'label' => 'Road', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'location', 'action' => 'add-road', 'label' => 'Add Road', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'location', 'action' => 'update-road', 'label' => 'Update Road', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'building' => [
                    ['module' => '', 'controller' => 'location', 'action' => 'building', 'label' => 'Building', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'location', 'action' => 'add-building', 'label' => 'Add Building', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'location', 'action' => 'update-building', 'label' => 'Update Building', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ]
            ]
        ],
        'configuration' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-wrench"],
            "items" => [
                'tax' => [
                    ['module' => '', 'controller' => 'config', 'action' => 'tax', 'label' => 'Tax', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'add-tax', 'label' => 'Add Tax', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'update-tax', 'label' => 'Update Tax', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'designation' => [
                    ['module' => '', 'controller' => 'config', 'action' => 'designation', 'label' => 'Designation', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'add-designation', 'label' => 'Add Designation', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'update-designation', 'label' => 'Update Designation', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'reason' => [
                    ['module' => '', 'controller' => 'config', 'action' => 'reason', 'label' => 'Reason', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'add-reason', 'label' => 'Add Reason', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'update-reason', 'label' => 'Update Reason', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'bank-master' => [
                    ['module' => '', 'controller' => 'config', 'action' => 'bank', 'label' => 'Bank Master', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'add-bank', 'label' => 'Add Bank', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'update-bank', 'label' => 'Update Bank', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'comp-cat' => [
                    ['module' => '', 'controller' => 'config', 'action' => 'comp-cat', 'label' => 'Complaint Category', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'add-comp-cat', 'label' => 'Add Complaint Category', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'update-comp-cat', 'label' => 'Update Complaint Category', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'voucher' => [
                    ['module' => '', 'controller' => 'config', 'action' => 'voucher', 'label' => 'Voucher/Coupons', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'config', 'action' => 'gen-voucher', 'label' => 'Generate Voucher/Coupons', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
            ]
        ],
        'policies' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-flash"],
            "items" => [
                'ip_pool' => [
                    ['module' => '', 'controller' => 'plan', 'action' => 'ippool', 'label' => 'IP Pool', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'plan', 'action' => 'add-ippool', 'label' => 'Add IP Pool', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plan', 'action' => 'update-ippool', 'label' => 'Update IP Pool', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                //   ['module' => '', 'controller' => 'plan', 'action' => 'assign-staticip', 'label' => 'Assign Static IP Policy', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'staticip_policy' => [
                    ['module' => '', 'controller' => 'plan', 'action' => 'staticip', 'label' => 'Static Ip Policy', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'plan', 'action' => 'add-staticip', 'label' => 'Add Static IP Policy', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plan', 'action' => 'update-staticip', 'label' => 'Update Static IP Policy', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plan', 'action' => 'assign-staticip', 'label' => 'Assign Static IP Policy', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'policy' => [
                    ['module' => '', 'controller' => 'plan', 'action' => 'index', 'label' => 'Plan', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'plan', 'action' => 'add-plan', 'label' => 'Add Plan', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plan', 'action' => 'update-plan', 'label' => 'Update Plan', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'ott' => [
                    ['module' => '', 'controller' => 'plan', 'action' => 'ott', 'label' => 'OTT', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'plan', 'action' => 'sync-ott', 'label' => 'Synch Plan', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                'bouquet' => [
                    ['module' => '', 'controller' => 'plan', 'action' => 'bouquet', 'label' => 'Bouquet', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'plan', 'action' => 'add-bouquet', 'label' => 'Add Bouquet', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plan', 'action' => 'update-bouquet', 'label' => 'Update Bouquet', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plan', 'action' => 'assign-bouquet', 'label' => 'Assign Bouquet', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plan', 'action' => 'deassign-bouquet', 'label' => 'De-Assign Bouquet', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
            ]
        ],
        'inventory' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-microchip"],
            "items" => [
                "vendor" => [
                    ['module' => '', 'controller' => 'inventory', 'action' => 'vendor', 'label' => 'Vendor', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'inventory', 'action' => 'add-vendor', 'label' => 'Add Vendor', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'inventory', 'action' => 'update-vendor', 'label' => 'Update Vendor', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                "device" => [
                    ['module' => '', 'controller' => 'inventory', 'action' => 'device', 'label' => 'Device', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'inventory', 'action' => 'add-device', 'label' => 'Add Device', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'inventory', 'action' => 'update-device', 'label' => 'Update Device', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                "requisition" => [
                    ['module' => '', 'controller' => 'inventory', 'action' => 'device-requisition', 'label' => 'Device Requisition', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'inventory', 'action' => 'create-requisition', 'label' => 'Request Requisition', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'inventory', 'action' => 'approve-requisition', 'label' => 'Approve Requisition', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'inventory', 'action' => 'final-approve-requisition', 'label' => 'Final Approval Requisition', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                "device_stock" => [
                    ['module' => '', 'controller' => 'inventory', 'action' => 'device-stock', 'label' => 'Device Stock', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'inventory', 'action' => 'inward-device', 'label' => 'Inward Device', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
                "device_allotment" => [
                    ['module' => '', 'controller' => 'inventory', 'action' => 'alloted-stock', 'label' => 'Alloted Device', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'inventory', 'action' => 'allot-device', 'label' => 'Allot Device', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ]
            ]
        ],
        'plugin' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-wifi"],
            "items" => [
                'plugin' => [
                    ['module' => '', 'controller' => 'plugin', 'action' => 'index', 'label' => 'Plugin', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plugin', 'action' => 'add-sms', 'label' => 'SMS', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plugin Gateway', 'action' => 'add-pg', 'label' => 'Payment Gateway', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plugin', 'action' => 'add-nas', 'label' => 'NAS', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plugin', 'action' => 'add-ott', 'label' => 'OTT', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
//                    ['module' => '', 'controller' => 'nas', 'action' => 'update-nas', 'label' => 'Update NAS', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
//                    ['module' => '', 'controller' => 'nas', 'action' => 'manage-nas', 'label' => 'NAS Management', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
//                    ['module' => '', 'controller' => 'nas', 'action' => 'activate-nas', 'label' => 'Activate Nas', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
//                    ['module' => '', 'controller' => 'nas', 'action' => 'restart-nas', 'label' => 'Reboot NAS', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
//                    ['module' => '', 'controller' => 'nas', 'action' => 'flush-users', 'label' => 'Flush Users', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"]
                ]
            ]
        ],
        "scheduleJobs" => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-connectdevelop"],
            "items" => [
                "renew_accounts" => [
                    ['module' => '', 'controller' => 'bulk', 'action' => 'renew-accounts', 'label' => 'Renew Accounts', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]]
                ],
                "suspend_resume" => [
                    ['module' => '', 'controller' => 'bulk', 'action' => 'suspend-resume', 'label' => 'Suspend/Resume', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "policy_refresh" => [
                    ['module' => '', 'controller' => 'bulk', 'action' => 'attr-refresh', 'label' => 'Policy Refresh', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "terminate_accounts" => [
                    ['module' => '', 'controller' => 'bulk', 'action' => 'terminate', 'label' => 'Terminate Accounts', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "customer_shifting" => [
                    ['module' => '', 'controller' => 'bulk', 'action' => 'customer-shift', 'label' => 'Customer Shift', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
                "bulk_activity_jobs" => [
                    ['module' => '', 'controller' => 'mig', 'action' => 'index', 'label' => 'Bulk Upload Jobs', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                    ['module' => '', 'controller' => 'mig', 'action' => 'migration-jobs', 'label' => 'Bulk Upload Jobs', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline", "apply_to" => [C::DESIG_OPERATOR, C::DESIG_DISTRIBUTOR, C::DESIG_RO]],
                ],
            ]
        ]
    ];

    public static function getDisplayMenu($menu = [], $is_submenu = false) {
        $menu = empty($menu) ? self::$menu : $menu;
        $result = [];
        foreach ($menu as $key => $mvalues) {
            $menuItems = empty($mvalues['items']) ? $mvalues : $mvalues['items'];
            $menuConfig = empty($mvalues['config']) ? [] : $mvalues['config'];
            $is_submenu = count($menuItems) > 1 ? true : false;
            if (\yii\helpers\ArrayHelper::isAssociative($menuItems)) {
                foreach ($menuItems as $k => $m) {
                    if ($is_submenu) {
                        $label = self::styleMenuLabel($key, $menuConfig);
                        $result[$key] = [
                            'url' => "#",
                            'label' => $label,
                            'options' => ['class' => 'br-menu-item'],
                            'items' => array_values(self::getDisplayMenu($menuItems)),
                            'submenuTemplate' => "\n<ul class = 'br-menu-sub '>\n{items}\n</ul>\n",
                            'template' => '<a href="{url}" class="br-menu-link  with-sub">{label}</a>',
                        ];
                    } else {
                        $mv = current($m);
                        $label = self::styleMenuLabel($mv['label'], $menuConfig);
                        $result[$k] = [
                            'url' => \Yii::$app->urlManager->createUrl(implode("/", [$mv['module'], $mv['controller'], $mv['action']])),
                            'label' => $label,
                            'options' => ['class' => 'br-menu-item'],
                            'template' => '<a href="{url}" class="br-menu-link">{label}</a>',
                        ];
                    }
                }
            } else {
                foreach ($menuItems as $k => $mv) {
                    if ($mv['is_menu']) {
                        $result[$key] = [
                            'url' => \Yii::$app->urlManager->createUrl(implode("/", [$mv['module'], $mv['controller'], $mv['action']])),
                            'label' => $mv['label'],
                            'template' => '<a href="{url}" class="sub-link">{label}</a>',
                            'options' => ['class' => "sub-item "],
                        ];
                    }
                }
            }
        }
        return $result;
    }

    public static function styleMenuLabel($label, $menuConfig = []) {
        $text = ucwords(implode(' ', preg_split('/(?=[A-Z])/', $label)));
        $label = "";
        if (!empty($menuConfig)) {
            $label .= Html::tag("i", "", ["class" => $menuConfig['class']]);
        }
        $label .= Html::tag('span', $text, ['class' => "menu-item-label"]);
        return $label;
    }

    public static function getDisplayTitle($menu = []) {
        $menu = empty($menu) ? self::$menu : $menu;
        $menuItem = !empty($menu['items']) ? $menu['items'] : $menu;
        $title = [];
        $st = [];
        foreach ($menuItem as $k => $m) {
            if (ArrayHelper::isAssociative($m)) {
                $st = self::getDisplayTitle($m);
            } else {
                foreach ($m as $sk => $sm) {
                    extract($sm);
                    $st[$controller][$action] = ['title' => $label, 'icon' => $icon];
                }
            }
            $title = ArrayHelper::merge($title, $st);
        }
        return $title;
    }

    public static function renderMenu() {
        return MenuHelper::getDisplayMenu();
        return \Yii::$app->cache->getOrSet('menu', function () {
                    return MenuHelper::getDisplayMenu();
                });
    }

    public static function renderPageTitle($c = "", $a = "") {
        $titleList = \Yii::$app->cache->getOrSet('titles', function () {
            return MenuHelper::getDisplayTitle();
        });
        return !empty($titleList[$c][$a]) ? $titleList[$c][$a] : SITE_NAME;
    }

    public static function getNotification() {
        return '';
    }

    public static function getAccountSetting() {

        $user = \Yii::$app->user->getIdentity();
        if (empty($user)) {
            \Yii::$app->controller->redirect('site/logout');
        }

        $link = [
            'profile' => Html::a('<i class="icon ion-ios-person"></i>Profile', \Yii::$app->urlManager->createUrl('site/profile')),
            'password' => Html::a('<i class="icon ion-ios-gear"></i>Change Password', \Yii::$app->urlManager->createUrl('site/changes-password')),
            'logout' => Html::a('<i class="icon ion-power"></i>Sign Out', \Yii::$app->urlManager->createUrl('site/logout')),
        ];

        $label = Html::a(
                        Html::tag("div", substr($user['name'], 0, 1), ["class" => "tx-center text-uppercase font-weight-bold font- text-white"]), '#', ["class" => "nav-link nav-link-profile bg-teal rounded-circle mg-10", "data-toggle" => "dropdown"]
        );

        $dropdown = Html::tag(
                        'div', Html::tag(
                                'div', Html::tag("h6", $user['name'], ["class" => "logged-fullname"]), ['class' => 'tx-center']
                        ) .
                        Html::tag("hr") .
                        Html::ul($link, ["class" => "list-unstyled user-profile-nav", 'item' => function ($item, $index) {
                                return Html::tag('li', $item);
                            }]), ['class' => "dropdown-menu dropdown-menu-header wd-250"]
        );

        return Html::tag('div', $label . $dropdown, ['class' => 'dropdown']);
    }

    public static function reArrangeMenu() {
        $menus = self::$menu;

        foreach ($menus as $headers => $items) {
            $res[$headers] = ["header" => $headers, "css" => $items['config']['class']];
            foreach ($items['items'] as $mainItem => $subitems) {
                $res[$headers]['items'][$mainItem] = ArrayHelper::getColumn($subitems, function ($m) {
                            return ['id' => $m['controller'] . "-" . $m['action'], 'label' => $m['label']];
                        });
            }
        }
        return $res;
    }

}

/**
 * if ($is_submenu) {
  print_R($key);
  print_R($mvalues);
  exit;
  }
  if (\yii\helpers\ArrayHelper::keyExists('controller', $mvalues)) {
  if ($mvalues['is_menu']) {
  $data = [
  'url' => \Yii::$app->urlManager->createUrl(implode("/", [$mvalues['module'], $mvalues['controller'], $mvalues['action']])),
  'label' => $mvalues['label'],
  'options' => ['class' => 'br-menu-item'],
  ];
  $result = $is_submenu ? [$key => $data] : $data;
  }
  } else {
  $result[$key] = count($mvalues) == 1 ?
  self::getDisplayMenu(current($mvalues), false) :
  self::getDisplayMenu(current($mvalues), true);
  }
 */
    