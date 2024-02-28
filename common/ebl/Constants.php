<?php

namespace common\ebl;

use yii\helpers\ArrayHelper;

class Constants
{

    const DESIGNATION_OPERATOR = -3;
    const DESIGNATION_DISTRIBUTOR = -2;
    const DESIGNATION_SADMIN = -1;
    const DAYS_IN_MONTH = 30;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_PENDING = -1;
    const STATUS_EXPIRED = 2;
    const STATUS_CANCELLED = 3;
    const STATUS_CLOSED = 4;
    const STATUS_INACTIVATE_REFUND = 5;
    const STATUS_TERMINATE = 6;
    const CONSOLE_ID = -1;
    const USERTYPE_SUBSCRIBER = -3;
    const USERTYPE_CONSOLE = -2;
    const USERTYPE_ADMIN = -1;
    const USERTYPE_MSO = 0;
    const USERTYPE_RO = 1;
    const USERTYPE_DISTRIBUTOR = 2;
    const USERTYPE_OPERATOR = 3;
    const USERTYPE_STAFF = 4;
    const DESIG_SUBSCRIBER = -3;
    const DESIG_ADMIN = -1;
    const DESIG_MSO = 0;
    const DESIG_RO = 1;
    const DESIG_DISTRIBUTOR = 2;
    const DESIG_OPERATOR = 3;
    const LOCATION_STATE = 1;
    const LOCATION_CITY = 2;
    const LOCATION_AREA = 3;
    const LOCATION_ROAD = 4;
    const LOCATION_BUILDING = 5;
    const TAX_PERCENTAGE = 1;
    const TAX_AMOUNT = 2;
    const REASON_FOR_COMPLAINT = 'COMP';
    const REASON_FOR_CHARGES = 'CHRG';
    const REASON_FOR_SUBSCRIBER = 'SUBS';
    const REASON_FOR_INSTALLATION = 'INST';
    const TAX_APPLICABLE_PLAN = "PLAN";
    const TAX_APPLICABLE_DEVICE = "Device";
    const TAX_TYPE_PERCENTAGE = 1;
    const TAX_TYPE_AMOUNT = 0;
    const PLAN_TYPE_BASE = 1;
    const PLAN_TYPE_ADDONS = 2;
    const BILLING_TYPE_POSTPAID = 1;
    const BILLING_TYPE_PREPAID = 2;
    const LIMIT_IN_GB = 1;
    const LIMIT_IN_HRS = 2;
    const OPERATOR_TYPE_MSO = 1;
    const OPERATOR_TYPE_RO = 2;
    const OPERATOR_TYPE_DISTRIBUTOR = 3;
    const OPERATOR_TYPE_LCO = 4;
    const USER_TYPE_SUBSCRIBER = 5;
    const OPERATOR_TYPE_MSO_NAME = 'MSO';
    const OPERATOR_TYPE_RO_NAME = 'RO';
    const OPERATOR_TYPE_DISTRIBUTOR_NAME = 'Distributor';
    const OPERATOR_TYPE_LCO_NAME = 'Franchise';
    const PAY_MODE_CASH = 1;
    const PAY_MODE_Cheque = 2;
    const PAY_MODE_DD = 3;
    const PAY_MODE_NEFT_RTFS = 4;
    const PAY_MODE_ONLINE_TRANSFER = 5;
    const PAY_MODE_DEBIT_CARD = 6;
    const PAY_MODE_CREDIT_CARD = 7;
    const PAY_MODE_PAYTM = 8;
    const PAY_MODE_OTHER = 9;
    const PAY_MODE_RECHARGE_COUPON = 10;
    const PAY_MODE_PAYMENT_GATEWAY = 11;
    const INST_PENDING = 1;
    const INST_DEPOSITED = 2;
    const INST_CANCELLED = 3;
    const INST_BOUNCE = 4;
    const INST_REALISED = 5;
    const LIMIT_TYPE_PER_DAY = 1;
    const LIMIT_TYPE_PLAN_BASED = 2;
    const LIMIT_UNIT_GB = 1;
    const LIMIT_UNIT_TIME = 2;
    const YES = 1;
    const NO = 0;
    const CONNECTION_RESIDENTIAL = 1;
    const CONNECTION_COMMERCIAL = 2;
    const MALE = 1;
    const FEMALE = 2;
    const LIMIT_DATA_BASED = 1;
    const LIMIT_SESSION_BASED = 2;
    const RESET_PLAN_NO = 0;
    const RESET_PERDAY = 1;
    const RESET_PLAN_MONTHLY = 2;
    const RESET_PLAN_BASED = 3;
    const RATE_TYPE_BOUQUET = 1;
    const RATE_TYPE_STATICIP = 2;
    const MACBIND_AUTO_ONE = 1;
    const MACBIND_AUTO_MULTIPLE = 2;
    const PROSPECT_VERIFY = 1;
    const PROSPECT_INSTALLATION = 2;
    const PROSPECT_FINAL_VERIFY = 3;
    const PROSPECT_CALL_CLOSED = 4;
    const COMPLAINT_PENDING = 1;
    const COMPLAINT_CLOSED = 2;
    const ACCOUNT_TYPE_PPPOE = 1;
    const ACCOUNT_TYPE_ILL = 2;
    const PARTICULAR_TYPE_CREDIT = 1;
    const PARTICULAR_TYPE_DEBIT = 2;
    const ASSIGNMENT_TYPE_OPERATOR = 1;
    const VOUCHER_ACTIVE = 1;
    const VOUCHER_ASSGNED = 2;
    const VOUCHER_EXPIRED = 3;
    const PAYMENT_PENDING = -1;
    const PAYMENT_SUCCESS = 1;
    const PAYMENT_FAILED = 2;
    const CONFIG_PAYMENT = "PG";
    const MEASURE_IN_QUANTITY = 1;
    const MEASURE_IN_WEIGHT = 2;
    const MEASURE_IN_LENGTH = 3;
    const DEVICE_ATTRIBUTE_LIST = [
        "serial_no"
    ];
    const ATTRIBUTE_VALIDATION_APHABETS = 1;
    const ATTRIBUTE_VALIDATION_NUMERIC = 2;
    const ATTRIBUTE_VALIDATION_APHANUMERIC = 3;
    const ATTRIBUTE_VALIDATION_HEX = 4;
    const ATTRIBUTE_VALIDATION_MAC_ADDRESS = 5;
    const ATTRIBUTE_VALIDATION_TYPE = [
        self::ATTRIBUTE_VALIDATION_APHABETS => "Alphabets",
        self::ATTRIBUTE_VALIDATION_NUMERIC => "Numeric",
        self::ATTRIBUTE_VALIDATION_APHANUMERIC => "Alpha Numeric",
        self::ATTRIBUTE_VALIDATION_HEX => "Hexadecimal",
        self::ATTRIBUTE_VALIDATION_MAC_ADDRESS => "MAC Address",
    ];
    const PG_TYPE_CCAVENUE = 1;
    const PG_TYPE_PATM = 2;
    const PG_TYPE_PAYU = 3;
    const PG_TYPE_ATOM = 4;
    const PG_TYPE_NSDL = 5;
    const PG_TYPE_AGGREPAY = 6;
    const NAS_MIKROTIK = 1;
    const NAS_HUAWEI = 2;
    const NAS_JUNIPER = 3;
    const NAS_CISCO = 4;
    const INVENTORY_STATUS_NEW = 1;
    const INVENTORY_STATUS_FAULTY = 2;
    const INVENTORY_STATUS_REPAIRED = 3;
    const INVENTORY_STATUS_DAMAGED = 4;

    const SERVICE_TYPE_PACKAGE = 1;
    const SERVICE_TYPE_CHANNEL = 2;
    const SERVICE_TYPE_BROADCASTER = 3;
    const SERVICE_TYPE_OTT = 4;
    /*     * *************Transaction types**************************** */
    const TRANS_DR_SUBSCRIPTION_CHARGES = 1;
    const TRANS_CR_SUBSCRIPTION_REFUND_CHARGES = 2;

    /**
     * Operator Charges and credit
     */
    const TRANS_CR_OPERATOR_WALLET_RECHARGE = 3;
    const TRANS_CR_OPERATOR_ONLINE_WALLET_RECHARGE = 4;
    const TRANS_CR_OPERATOR_CREDIT_NOTE = 5;
    const TRANS_DR_OPERATOR_DEBIT_NOTE = 6;
    const TRANS_DR_OPERATOR_AMOUNT_REVERSAL = 7;
    const TRANS_DR_CANCEL_ON_RECON = 8;
    const TRANS_DR_BOUNCE_ON_RECON = 9;
    const TRANS_DR_BOUNCE_CHARGES = 10;

    /**
     * Subscriber Charges and credit
     */
    const TRANS_DR_SUBCRIBER_PREVIOUS_DUE = 11;
    const TRANS_DR_ADDITION_CHARGES = 12;
    const TRANS_DR_SUBSCRIBER_INSTALLATION_CHARGE = 13;
    const TRANS_CR_SUBSCRIBER_BADDEPTH_CHARGES = 14;
    const TRANS_CR_ADDITION_DISCOUNT = 15;
    const TRANS_CR_SUBSCRIBER_PAYMENT = 16;
    const TRANS_CR_SUBSCRIBER_ONLINE_PAYMENT = 17;
    const TRANS_DR_SUBSCRIBER_PAYMENT_REVERSAL = 18;
    const ONLINE_PAYMENT_PENDING = 0;
    const ONLINE_PAYMENT_SUCESS = 1;
    const ONLINE_PAYMENT_FAILED = 2;

    /**
     * 
     */
    const TRANS_LABEL = [
        self::TRANS_DR_SUBSCRIBER_INSTALLATION_CHARGE => "Installation Charges",
        self::TRANS_CR_SUBSCRIBER_PAYMENT => "Offline Payment",
        self::TRANS_DR_SUBSCRIPTION_CHARGES => "Subscription Charges",
        self::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES => "Subscription Refund",
        self::TRANS_CR_SUBSCRIBER_BADDEPTH_CHARGES => 'BAD Depth',
        self::TRANS_CR_ADDITION_DISCOUNT => "Additional Discount",
        self::TRANS_DR_SUBCRIBER_PREVIOUS_DUE => "Previous Due",
        self::TRANS_CR_OPERATOR_WALLET_RECHARGE => "Offline Payment",
        self::TRANS_DR_ADDITION_CHARGES => "Aditional Charges",
        self::TRANS_CR_OPERATOR_CREDIT_NOTE => "Credit Note",
        self::TRANS_DR_OPERATOR_DEBIT_NOTE => "Debit Note",
        self::TRANS_DR_CANCEL_ON_RECON => "Cancelled",
        self::TRANS_DR_BOUNCE_ON_RECON => "Bounce",
        self::TRANS_DR_BOUNCE_CHARGES => "Bounce Charges",
        self::TRANS_CR_OPERATOR_ONLINE_WALLET_RECHARGE => "Online Wallet recharge",
        self::TRANS_CR_SUBSCRIBER_PAYMENT => "Payment(CR)",
    ];
    const SUBSCRIBER_ACTIVATION_CHARGES = [
        self::TRANS_DR_SUBSCRIBER_INSTALLATION_CHARGE => 'Installation Charges (DR)',
        self::TRANS_CR_SUBSCRIBER_PAYMENT => "Payment(CR)",
        self::TRANS_DR_SUBCRIBER_PREVIOUS_DUE => "Previous Due(DR)",
        self::TRANS_DR_ADDITION_CHARGES => "Additional Charges (DR)"
    ];
    const SUBSCRIBER_CHARGES = [
        self::TRANS_DR_SUBSCRIBER_INSTALLATION_CHARGE => 'Installation Charges (DR)',
        self::TRANS_DR_SUBCRIBER_PREVIOUS_DUE => "Previous Due(DR)",
        self::TRANS_DR_ADDITION_CHARGES => "Additional Charges (DR)"
    ];
    const OPERATOR_COLLECTIONS = [
        self::TRANS_CR_OPERATOR_WALLET_RECHARGE, self::TRANS_CR_OPERATOR_ONLINE_WALLET_RECHARGE
    ];
    const TRANSACTION_RECONSILE_RECONSILE = [self::TRANS_CR_SUBSCRIBER_PAYMENT, self::TRANS_CR_OPERATOR_WALLET_RECHARGE];
    const TRANSACTION_TYPE_OPT_CREDIT = [self::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES, self::TRANS_CR_OPERATOR_WALLET_RECHARGE, self::TRANS_CR_OPERATOR_CREDIT_NOTE, self::TRANS_CR_OPERATOR_ONLINE_WALLET_RECHARGE];
    const TRANSACTION_TYPE_OPT_DEBIT = [self::TRANS_DR_SUBSCRIPTION_CHARGES, self::TRANS_DR_OPERATOR_DEBIT_NOTE, self::TRANS_DR_BOUNCE_CHARGES, self::TRANS_DR_BOUNCE_ON_RECON, self::TRANS_DR_CANCEL_ON_RECON];
    const TRANSACTION_TYPE_SUB_CREDIT = [self::TRANS_CR_ADDITION_DISCOUNT, self::TRANS_CR_SUBSCRIBER_BADDEPTH_CHARGES, self::TRANS_CR_SUBSCRIBER_PAYMENT, self::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES];
    const TRANSACTION_TYPE_SUB_COLLECTION = [self::TRANS_CR_SUBSCRIBER_PAYMENT, self::TRANS_CR_SUBSCRIBER_ONLINE_PAYMENT];
    const TRANSACTION_TYPE_SUB_DEBIT = [self::TRANS_DR_SUBSCRIBER_INSTALLATION_CHARGE, self::TRANS_DR_SUBCRIBER_PREVIOUS_DUE, self::TRANS_DR_ADDITION_CHARGES, self::TRANS_DR_SUBSCRIPTION_CHARGES];
    const TRANS_DR_SUBSCRIBER_INSTALLATION_CHARGE_PFX = 'CSDI';
    const TRANS_CR_SUBSCRIBER_PAYMENT_PFX = 'CSDP';
    const TRANS_DR_SUBSCRIPTION_CHARGES_PFX = 'CSDC';
    const TRANS_CR_SUBSCRIPTION_REFUND_CHARGES_PFX = 'CSCC';
    const TRANS_CR_SUBSCRIBER_BADDEPTH_CHARGES_PFX = 'CSCB';
    const TRANS_CR_ADDITION_DISCOUNT_PFX = 'CSCA';
    const TRANS_DR_SUBCRIBER_PREVIOUS_DUE_PFX = 'CSDD';
    const ONLINE_PAYMENT_PFX = "CTOP";
    const OPERATOR_CHARGE_LIST = [
        "payment" => [
            "credit" => [self::TRANS_CR_OPERATOR_WALLET_RECHARGE, self::TRANS_CR_OPERATOR_ONLINE_WALLET_RECHARGE],
            "debit" => [self::TRANS_DR_OPERATOR_AMOUNT_REVERSAL],
            "is_tax" => 0
        ],
        "plans" => [
            "credit" => [self::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES],
            "debit" => [self::TRANS_DR_SUBSCRIPTION_CHARGES],
            "is_tax" => 1
        ],
        "credit" => [
            "credit" => [self::TRANS_CR_OPERATOR_CREDIT_NOTE],
            "debit" => [],
            "is_tax" => 1
        ],
        "credit_nt" => [
            "credit" => [self::TRANS_CR_OPERATOR_CREDIT_NOTE],
            "debit" => [],
            "is_tax" => 0
        ],
        "debit" => [
            "credit" => [],
            "debit" => [self::TRANS_DR_OPERATOR_DEBIT_NOTE],
            "is_tax" => 1
        ],
        "debit_nt" => [
            "credit" => [],
            "debit" => [self::TRANS_DR_OPERATOR_DEBIT_NOTE],
            "is_tax" => 0
        ],
    ];
    const CUSTOMER_CHARGE_LIST = [
        "payment" => [
            "credit" => [self::TRANS_CR_SUBSCRIBER_ONLINE_PAYMENT, self::TRANS_CR_SUBSCRIBER_PAYMENT],
            "debit" => [self::TRANS_DR_SUBSCRIBER_PAYMENT_REVERSAL],
            "is_tax" => 0
        ],
        "plans" => [
            "credit" => [self::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES],
            "debit" => [self::TRANS_DR_SUBSCRIPTION_CHARGES],
            "is_tax" => 1
        ],
        "credit" => [
            "credit" => [self::TRANS_CR_SUBSCRIBER_BADDEPTH_CHARGES, self::TRANS_CR_ADDITION_DISCOUNT],
            "debit" => [],
            "is_tax" => 1
        ],
        "credit_nt" => [
            "credit" => [self::TRANS_CR_SUBSCRIBER_BADDEPTH_CHARGES, self::TRANS_CR_ADDITION_DISCOUNT],
            "debit" => [],
            "is_tax" => 0
        ],
        "debit" => [
            "credit" => [],
            "debit" => [self::TRANS_DR_ADDITION_CHARGES, self::TRANS_DR_SUBCRIBER_PREVIOUS_DUE, self::TRANS_DR_SUBSCRIBER_INSTALLATION_CHARGE],
            "is_tax" => 1
        ],
        "debit_nt" => [
            "credit" => [],
            "debit" => [self::TRANS_DR_ADDITION_CHARGES, self::TRANS_DR_SUBCRIBER_PREVIOUS_DUE, self::TRANS_DR_SUBSCRIBER_INSTALLATION_CHARGE],
            "is_tax" => 0
        ],
    ];
    const LABEL_TRANS_PREFIX = [
        self::TRANS_DR_SUBSCRIBER_INSTALLATION_CHARGE => self::TRANS_DR_SUBSCRIBER_INSTALLATION_CHARGE_PFX,
        self::TRANS_CR_SUBSCRIBER_PAYMENT => self::TRANS_CR_SUBSCRIBER_PAYMENT_PFX,
        self::TRANS_DR_SUBSCRIPTION_CHARGES => self::TRANS_DR_SUBSCRIPTION_CHARGES_PFX,
        self::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES => self::TRANS_CR_SUBSCRIPTION_REFUND_CHARGES_PFX,
        self::TRANS_CR_SUBSCRIBER_BADDEPTH_CHARGES => self::TRANS_CR_SUBSCRIBER_BADDEPTH_CHARGES_PFX,
        self::TRANS_CR_ADDITION_DISCOUNT => self::TRANS_CR_ADDITION_DISCOUNT_PFX,
        self::TRANS_DR_SUBCRIBER_PREVIOUS_DUE => self::TRANS_DR_SUBCRIBER_PREVIOUS_DUE_PFX
    ];

    /**
     * 
     */
    const RECONSILE_STATUS_PENDING = 1;
    const RECONSILE_STATUS_DEPOSITED = 2;
    const RECONSILE_STATUS_CANCELLED = 3;
    const RECONSILE_STATUS_BOUNCE = 4;
    const RECONSILE_STATUS_REALIZED = 5;

    /**
     * 
     */
    const PLUGIN_TYPE_MOBILE_SMS = 1;
    const PLUGIN_TYPE_PAYMENT_GATEWAY = 2;
    const PLUGIN_TYPE_NAS = 3;
    const PLUGIN_TYPE_OTT = 5;
    const PLUGIN_TYPE_CAS = 4;
    const ACTIVITY_DEVICE_INWARDED = "Device_INWARD";
    const RENEWAL_TYPE_FRESH = 1;
    const RENEWAL_TYPE_RENEWAL = 2;

    /*     * **********Display Label fields*********************** */
    const LABEL_GENDER = [
        self::MALE => 'Male',
        self::FEMALE => 'Female'
    ];
    const LABEL_CONNECTION_TYPE = [
        self::CONNECTION_RESIDENTIAL => "Residential",
        self::CONNECTION_COMMERCIAL => "Commercial",
    ];
    const LABEL_STATUS = [
        self::STATUS_INACTIVE => 'In Active',
        self::STATUS_ACTIVE => 'Active',
    ];
    const LABEL_SUBSCRIBER_STATUS = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_EXPIRED => 'Expired',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_INACTIVATE_REFUND => 'Inactive and Refunded',
        self::STATUS_TERMINATE => 'Terminate',
    ];
    const LABEL_EXTRA_STATUS = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_INACTIVE => 'In Active',
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_EXPIRED => 'Expired',
        self::STATUS_CANCELLED => 'Cancelled',
    ];
    const LABEL_USERTYPE = [
        self::USERTYPE_ADMIN => 'Admin',
        self::USERTYPE_MSO => 'MSO',
        self::USERTYPE_OPERATOR => 'Franchise',
        self::USERTYPE_STAFF => 'Staff',
        self::USERTYPE_SUBSCRIBER => 'Subscriber',
    ];
    const LABEL_LOCATION = [
        self::LOCATION_STATE => "STATE",
        self::LOCATION_CITY => "CITY",
        self::LOCATION_AREA => 'AREA',
        self::LOCATION_ROAD => 'ROAD',
        self::LOCATION_BUILDING => 'BUILDING'
    ];
    const LABEL_REASONTYPE = [
        self::REASON_FOR_CHARGES => "Payment",
        self::REASON_FOR_COMPLAINT => "Complaint",
        self::REASON_FOR_SUBSCRIBER => "Subscription",
        self::REASON_FOR_INSTALLATION => "Installations"
    ];
    const LABEL_TAX_APPLICABLE_ON = [
        self::TAX_APPLICABLE_PLAN => "Internet Plan",
        self::TAX_APPLICABLE_DEVICE => "Device",
    ];

    public static $LABEL_TAX_TYPE = [
        self::TAX_TYPE_PERCENTAGE => "Percentage",
        self::TAX_TYPE_AMOUNT => "Amount"
    ];

    const LABEL_PLAN_TYPE = [
        self::PLAN_TYPE_BASE => "Base",
        self::PLAN_TYPE_ADDONS => "Addons",
    ];
    const LABEL_BILLING_TYPE = [
        self::BILLING_TYPE_POSTPAID => "Postpaid",
        self::BILLING_TYPE_PREPAID => "Prepaid",
    ];
    const LABEL_LIMIT_VALUES = [
        self::LIMIT_IN_GB => 'GB',
        self::LIMIT_IN_HRS => 'Hrs'
    ];
    const OPERATOR_TYPE_LABEL = [
        self::OPERATOR_TYPE_MSO => self::OPERATOR_TYPE_MSO_NAME,
        self::OPERATOR_TYPE_RO => self::OPERATOR_TYPE_RO_NAME,
        self::OPERATOR_TYPE_DISTRIBUTOR => self::OPERATOR_TYPE_DISTRIBUTOR_NAME,
        self::OPERATOR_TYPE_LCO => self::OPERATOR_TYPE_LCO_NAME,
    ];
    const LABEL_PAY_MODE = [
        self::PAY_MODE_CASH => "Cash",
        self::PAY_MODE_Cheque => "Cheque",
        self::PAY_MODE_DD => "DD",
        self::PAY_MODE_NEFT_RTFS => "NEFT/RTFS/IMPS",
        self::PAY_MODE_ONLINE_TRANSFER => "Online Transfer",
        self::PAY_MODE_DEBIT_CARD => "Debit Card",
        self::PAY_MODE_CREDIT_CARD => "Credit Card",
        self::PAY_MODE_PAYTM => "PAY TM",
        self::PAY_MODE_OTHER => "Other",
        self::PAY_MODE_RECHARGE_COUPON => "Recharge Coupon",
        self::PAY_MODE_PAYMENT_GATEWAY => "Online Payment"
    ];
    const LABEL_YESNO = [
        self::STATUS_ACTIVE => "YES",
        self::STATUS_INACTIVE => "No"
    ];
    const LABEL_HDSD = [
        self::STATUS_ACTIVE => "HD",
        self::STATUS_INACTIVE => "SD"
    ];
    const LABEL_DAYS_TYPES = [
        1 => "Monday",
        2 => "Tuesday",
        3 => "Wednesday",
        4 => "Thrusday",
        5 => "Friday",
        6 => "Saturday",
        7 => "Sunday",
        8 => "WeekDays",
        9 => "Weekend",
        10 => "All Days",
    ];
    const LIMIT_TYPE = [
        self::LIMIT_TYPE_PER_DAY => "Per Day",
        self::LIMIT_TYPE_PLAN_BASED => "Plan Based"
    ];
    const LIMIT_UNIT = [
        self::LIMIT_UNIT_GB => "GB",
        self::LIMIT_IN_HRS => "Session"
    ];
    const CONFIRM_LABEL = [
        self::YES => "Yes",
        self::NO => 'No'
    ];
    const LIMIT_LABEL = [
        self::LIMIT_DATA_BASED => "Data (GB)",
        self::LIMIT_SESSION_BASED => "Time (HRS)"
    ];
    const RESET_LABEL = [
        self::RESET_PLAN_NO => "No",
        self::RESET_PERDAY => "Per Day",
        self::RESET_PLAN_MONTHLY => "Monthly",
        self::RESET_PLAN_BASED => "Based on Plan"
    ];
    const MACBING_LABEL = [
        self::MACBIND_AUTO_ONE => "Single MAC Binding Auto",
        self::MACBIND_AUTO_MULTIPLE => "Multiple MAC Binding Auto"
    ];
    const PROSPECT_SATGES = [
        self::PROSPECT_VERIFY => "KYC",
        self::PROSPECT_INSTALLATION => "Installation",
        self::PROSPECT_FINAL_VERIFY => "Finalize",
        self::PROSPECT_CALL_CLOSED => "CLOSED",
    ];
    const PROSPECT_STAGES_COLOR_CODE = [
        self::PROSPECT_VERIFY => ["class" => "danger", 'hashcode' => '#dc3545', "label" => "Verify"],
        self::PROSPECT_INSTALLATION => ["class" => "warning", 'hashcode' => '#f49917', "label" => "Installation"],
        self::PROSPECT_FINAL_VERIFY => ["class" => "primary", 'hashcode' => '#007bff', "label" => "Final Verify"],
        self::PROSPECT_CALL_CLOSED => ["class" => "success", 'hashcode' => '#23bf08', "label" => "Closed"],
    ];
    const COMPLAINT_SATGES = [
        self::COMPLAINT_PENDING => "Pending",
        self::COMPLAINT_CLOSED => "CLOSED",
    ];
    const COMPLAINT_STAGES_COLOR_CODE = [
        self::COMPLAINT_PENDING => ["class" => "danger", 'hashcode' => '#dc3545', "label" => "Pending"],
        self::COMPLAINT_CLOSED => ["class" => "success", 'hashcode' => '#23bf08', "label" => "Closed"],
    ];
    const PARTICULAR_LABEL = [
        self::PARTICULAR_TYPE_CREDIT => "Credit",
        self::PARTICULAR_TYPE_DEBIT => "Debit"
    ];
    const PARTICULAR_TYPE_LABEL = [
        1 => "Offline Payment",
        2 => "Online Payment",
    ];
    const LABEL_ACCOUNT_TYPE = [
        self::ACCOUNT_TYPE_PPPOE => "PPOE",
        self::ACCOUNT_TYPE_ILL => "ILL"
    ];
    const LABEL_RECONSILE_STATUS = [
        self::RECONSILE_STATUS_PENDING => "Pending",
        self::RECONSILE_STATUS_DEPOSITED => "Deposited",
        self::RECONSILE_STATUS_CANCELLED => "Cancelled",
        self::RECONSILE_STATUS_BOUNCE => "Bounce",
        self::RECONSILE_STATUS_REALIZED => "Realized"
    ];
    const LABEL_VOUCHER = [
        self::VOUCHER_ACTIVE => "Active",
        self::VOUCHER_ASSGNED => "Assigned",
        self::VOUCHER_EXPIRED => "Expired"
    ];
    const BOUQUET_ASSET_INTERNET = 1;
    const BOUQUET_ASSET_OTT = 2;
    const LABEL_BOUQUET_ASSET_TYPE = [
        self::BOUQUET_ASSET_INTERNET => "Internet",
        self::BOUQUET_ASSET_OTT => "OTT"
    ];
    const BOUQUET_ASSET_TYPE_CONDITIONS = [
        self::BOUQUET_ASSET_INTERNET => ["label" => "Internet", "multiple" => false],
        self::BOUQUET_ASSET_OTT => ["label" => "OTT", "multiple" => true],
    ];
    const LABEL_MEASUREMENT = [
        self::MEASURE_IN_QUANTITY => "Quantity",
        self::MEASURE_IN_WEIGHT => "Weight",
        self::MEASURE_IN_LENGTH => "Length"
    ];
    const LABEL_DEVICE_STATUS = [
        self::INVENTORY_STATUS_DAMAGED => "Damaged",
        self::INVENTORY_STATUS_FAULTY => "Faulty",
        self::INVENTORY_STATUS_NEW => "New",
        self::INVENTORY_STATUS_REPAIRED => "Repaired",
    ];
    const LABEL_PLUGIN_TYPE = [
        self::PLUGIN_TYPE_MOBILE_SMS => "SMS",
        self::PLUGIN_TYPE_PAYMENT_GATEWAY => "Payment Gateway",
        self::PLUGIN_TYPE_NAS => "NAS",
        self::PLUGIN_TYPE_CAS => "CAS",
        self::PLUGIN_TYPE_OTT => "OTT"
    ];
    const LABEL_PG = [
        self::PG_TYPE_CCAVENUE => "Cc Avenue",
        self::PG_TYPE_PATM => "PAYTM",
        self::PG_TYPE_PAYU => "PayU",
        self::PG_TYPE_ATOM => "Atom",
        self::PG_TYPE_NSDL => "NSDL",
        self::PG_TYPE_AGGREPAY => "Aggrepay"
    ];
    const LABEL_NAS = [
        self::NAS_MIKROTIK => "Mikrotik",
        self::NAS_HUAWEI => "HUAWEI",
        self::NAS_JUNIPER => "Juniper",
        self::NAS_CISCO => "Cisco"
    ];

    const SERVICE_TYPE = [
        self::SERVICE_TYPE_PACKAGE => "Package",
        self::SERVICE_TYPE_CHANNEL => "Channels",
        self::SERVICE_TYPE_BROADCASTER => "Broadcaster Package",
        self::SERVICE_TYPE_OTT => "OTT Service"
    ];

    /*     * *************Prefix code************************ */
    const PREFIX_STATE = "STAT";
    const PREFIX_CITY = "CIT";
    const PREFIX_AREA = "ARA";
    const PREFIX_ROAD = "ROD";
    const PREFIX_BUILDING = "BLD";
    const PREFIX_REASON = "RSN";
    const PREFIX_DESIG = "DN";
    const PREFIX_PLAN = "PL";
    const PREFIX_STATIC = "SP";
    const PREFIX_OPT_MSO = "MSO";
    const PREFIX_OPT_RO = "RO";
    const PREFIX_OPT_DS = "DST";
    const PREFIX_OPT_LMO = "FRA";
    const PREFIX_COMP = "CC";
    const PREFIX_SUBCOMP = "SC";
    const PREFIX_PERIOD = "PR";
    const PREFIX_STATICPOLICY = "SIP";
    const PREFIX_PROSPECT_SUSBCRIBER = "PS";
    const PREFIX_BOUQUET = "BQ";
    const PREFIX_VENDOR = "VD";
    const PREFIX_DEVICE = "DV";
    const PREFIX_SERVICE_CHANNEL = "CHL";
    const PREFIX_SERVICE_PACKAGE = "PCK";
    const PREFIX_SERVICE_OTT = "OTT";
    const PREFIX_OPT = [
        self::OPERATOR_TYPE_MSO => self::PREFIX_OPT_MSO,
        self::OPERATOR_TYPE_RO => self::PREFIX_OPT_RO,
        self::OPERATOR_TYPE_DISTRIBUTOR => self::PREFIX_OPT_DS,
        self::OPERATOR_TYPE_LCO => self::PREFIX_OPT_LMO
    ];
    const PREFIX_OFFLINE_RECHARGE = 'OFRC';
    const PREFIX_ONLINE_RECHARGE = 'ONRC';
    const PREFIX_CREDIT = 'OPCR';
    const PREFIX_DEBIT = 'OPDR';
    const PREFIX_NAS = "NS";
    const CONFIG_FOR_SYSTEM = 1;
    const CONFIG_FOR_SUBS = 2;
    const CONFIG_FOR_LCO = 3;
    const CONFIG_TYPE_NAS = "NAS";
    const POOL_DYNAMIC = 1;
    const POOL_STATIC = 2;
    const POOL_EXPIRED = 3;
    const IP_FREE = 1;
    const IP_ASSIGNED = 2;
    const PAY_FOR_OPT = 0;
    const PAY_FOR_SUB = 1;
    const POOL_TYPES = [
        self::POOL_DYNAMIC => "Dynamic",
        self::POOL_STATIC => "Static",
        self::POOL_EXPIRED => "Expired",
    ];
    const LABEL_JOB_STATUS = [
        \common\models\ScheduleJobLogs::JOB_PENDING => "Pending",
        \common\models\ScheduleJobLogs::JOB_PROCESS => "Processing",
        \common\models\ScheduleJobLogs::JOB_DONE => "Done",
        \common\models\ScheduleJobLogs::JOB_ERROR => "Error",
    ];
    const BULK_JOB_MODELS = [
        jobs\LocationMigrationJob::class => "Create Location",
        jobs\OperatorMigrationJob::class => "Create " . self::OPERATOR_TYPE_LCO_NAME,
        jobs\PlanMigrationJob::class => "Create Plan",
        jobs\BouquetMigrationJob::class => "Create Bouquet",
        jobs\PlanAllocationJob::class => "Allocate Bouquets to " . self::OPERATOR_TYPE_LCO_NAME,
        jobs\CustomerMigrationJob::class => "Create Customer",
        jobs\BulkWalletRechargeJob::class => "Recharge " . self::OPERATOR_TYPE_LCO_NAME . " Wallet",
        jobs\ReconsilationJob::class => "Reconsile Job Details",
        jobs\FinalReconsilationJob::class => "Final Reconsile Job Details",
        jobs\DeviceInwardJob::class => "Device Inward Jobs"
    ];
    const LABEL_JOB_MODELS = [
        jobs\LocationMigrationJob::class => "Create Location",
        jobs\OperatorMigrationJob::class => "Create " . self::OPERATOR_TYPE_LCO_NAME,
        jobs\PlanMigrationJob::class => "Create Plan",
        jobs\BouquetMigrationJob::class => "Create Bouquet",
        jobs\PlanAllocationJob::class => "Allocate Bouquet to " . self::OPERATOR_TYPE_LCO_NAME,
        jobs\CustomerMigrationJob::class => "Create Customer",
        jobs\BulkWalletRechargeJob::class => "Recharge " . self::OPERATOR_TYPE_LCO_NAME . " Wallet",
    ];
    const LABEL_ACTIVITY_MODELS = [];
}
