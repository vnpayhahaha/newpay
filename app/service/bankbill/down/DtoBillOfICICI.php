<?php

namespace app\service\bankbill\down;

use app\lib\annotation\ExcelData;
use app\lib\annotation\ExcelProperty;
use app\lib\LdlExcel\ModelExcel;
use app\model\ModelDisbursementOrder;
use Illuminate\Support\Collection;


#[ExcelData]
class DtoBillOfICICI implements ModelExcel
{
    #[ExcelProperty(value: "PYMT_PROD_TYPE_CODE", index: 0)]
    public string $pymt_prod_type_code = 'PAB_VENDOR';

    #[ExcelProperty(value: "PYMT_MODE", index: 1)]
    public string $pymt_mode = 'IMPS';

    #[ExcelProperty(value: "DEBIT_ACC_NO", index: 2)]
    public string $debit_acc_no;


    #[ExcelProperty(value: "BNF_NAME", index: 3)]
    public string $bnf_name;


    #[ExcelProperty(value: "BENE_ACC_NO", index: 4)]
    public string $bene_acc_no;

    #[ExcelProperty(value: "BENE_IFSC", index: 5)]
    public string $bene_ifsc;

    #[ExcelProperty(value: "AMOUNT", index: 6)]
    public string $amount;

    #[ExcelProperty(value: "CREDIT_NARR", index: 7)]
    public string $credit_narr;

    #[ExcelProperty(value: "PYMT_DATE", index: 8)]
    public string $pymt_date;

    #[ExcelProperty(value: "MOBILE_NUM", index: 9)]
    public string $mobile_num;

    #[ExcelProperty(value: "EMAIL_ID", index: 10)]
    public string $email_id;

    #[ExcelProperty(value: "REMARK", index: 11)]
    public string $remark;

    #[ExcelProperty(value: "REF_NO", index: 12)]
    public string $ref_no;

    // 构建电话号码，每次调用从[7,8,9]中随机一个作为开头，生成10位长度的随机数
    public static function generateMobileNum(): string
    {
        try {
            $prefix = random_int(7, 9);
            $suffix = '';
            for ($i = 0; $i < 9; $i++) {
                $suffix .= random_int(0, 9);
            }
        } catch (\Exception $e) {
            return '00000000000';
        }
        return $prefix . $suffix;
    }

    public static function formatData(Collection $orderData): array
    {
        $result = array();
        /** @var ModelDisbursementOrder $item */
        foreach ($orderData as $item) {
            $result[] = [
                'pymt_prod_type_code' => 'PAB_VENDOR',
                'pymt_mode'           => 'IMPS',
                'debit_acc_no'        => $item['bank_account']['account_number'] ?? '',
                'bnf_name'            => $item['bank_account']['account_holder']  ?? '',
                'bene_acc_no'         => $item['payee_account_no'] ?? '',
                'bene_ifsc'           => $item['payee_bank_code'] ?? '',
                'amount'              => (string)$item['amount'],
                'credit_narr'         => $item['platform_order_no'],
                'pymt_date'           => date('d-m-Y', strtotime($item['created_at'])),
                'mobile_num'          => $item['payee_phone'] ?? self::generateMobileNum(),
                'email_id'            => self::generateMobileNum() . '@gmail.com',
                'remark'              => $item['platform_order_no'],
                'ref_no'              => 'R' . $item['platform_order_no'],
            ];
        }
        return $result;
    }
}