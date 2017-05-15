<?php

use Illuminate\Database\Seeder;

class ExpressTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('express')->delete();

        \DB::table('express')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'express_name' => '7天连锁物流',
                    'express_code' => '7TLSWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:02:01',
                    'updated_at' => '2016-11-04 19:01:38',
                ),
            1 =>
                array (
                    'id' => 2,
                    'express_name' => '安捷快递',
                    'express_code' => 'AJ',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:09:39',
                    'updated_at' => '2016-11-04 19:06:08',
                ),
            2 =>
                array (
                    'id' => 3,
                    'express_name' => '安能物流',
                    'express_code' => 'ANE',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:09:56',
                    'updated_at' => '2016-11-04 19:06:15',
                ),
            3 =>
                array (
                    'id' => 4,
                    'express_name' => '安信达快递',
                    'express_code' => 'AXD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:10:16',
                    'updated_at' => '2016-11-04 19:06:26',
                ),
            4 =>
                array (
                    'id' => 5,
                    'express_name' => '巴伦支快递',
                    'express_code' => ' BALUNZHI',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:10:36',
                    'updated_at' => '2016-11-04 19:06:31',
                ),
            5 =>
                array (
                    'id' => 6,
                    'express_name' => '百福东方',
                    'express_code' => 'BFDF',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:11:02',
                    'updated_at' => '2016-11-04 19:06:49',
                ),
            6 =>
                array (
                    'id' => 7,
                    'express_name' => '宝凯物流',
                    'express_code' => 'BKWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:11:19',
                    'updated_at' => '2016-11-04 21:43:59',
                ),
            7 =>
                array (
                    'id' => 8,
                    'express_name' => '北青小红帽',
                    'express_code' => 'BQXHM',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:11:37',
                    'updated_at' => '2016-11-04 19:07:14',
                ),
            8 =>
                array (
                    'id' => 9,
                    'express_name' => '邦送物流',
                    'express_code' => 'BSWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:11:59',
                    'updated_at' => '2016-11-04 19:07:23',
                ),
            9 =>
                array (
                    'id' => 10,
                    'express_name' => '百世物流',
                    'express_code' => 'BTWL',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:12:16',
                    'updated_at' => '2016-11-05 09:32:30',
                ),
            10 =>
                array (
                    'id' => 11,
                    'express_name' => 'CCES快递',
                    'express_code' => 'CCES',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:12:32',
                    'updated_at' => '2016-11-04 19:07:43',
                ),
            11 =>
                array (
                    'id' => 12,
                    'express_name' => '城市100',
                    'express_code' => 'CITY100',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:12:49',
                    'updated_at' => '2016-11-04 19:07:57',
                ),
            12 =>
                array (
                    'id' => 13,
                    'express_name' => 'COE东方快递',
                    'express_code' => 'COE',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:13:05',
                    'updated_at' => '2016-11-04 19:08:01',
                ),
            13 =>
                array (
                    'id' => 14,
                    'express_name' => '长沙创一',
                    'express_code' => 'CSCY',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:13:19',
                    'updated_at' => '2016-11-04 19:08:07',
                ),
            14 =>
                array (
                    'id' => 15,
                    'express_name' => '传喜物流',
                    'express_code' => 'CXWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:13:34',
                    'updated_at' => '2016-11-04 19:08:17',
                ),
            15 =>
                array (
                    'id' => 16,
                    'express_name' => '德邦快递到付',
                    'express_code' => 'DBLKDDF',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:13:53',
                    'updated_at' => '2016-11-05 09:26:11',
                ),
            16 =>
                array (
                    'id' => 17,
                    'express_name' => '德创物流',
                    'express_code' => 'DCWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:14:07',
                    'updated_at' => '2016-11-04 19:08:23',
                ),
            17 =>
                array (
                    'id' => 18,
                    'express_name' => '东红物流',
                    'express_code' => 'DHWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:14:24',
                    'updated_at' => '2016-11-04 19:08:27',
                ),
            18 =>
                array (
                    'id' => 19,
                    'express_name' => 'D速物流',
                    'express_code' => 'DSWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:14:41',
                    'updated_at' => '2016-11-04 19:08:31',
                ),
            19 =>
                array (
                    'id' => 20,
                    'express_name' => '店通快递',
                    'express_code' => 'DTKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:15:00',
                    'updated_at' => '2016-11-04 19:08:35',
                ),
            20 =>
                array (
                    'id' => 21,
                    'express_name' => '大田物流',
                    'express_code' => 'DTWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:15:19',
                    'updated_at' => '2016-11-04 19:08:40',
                ),
            21 =>
                array (
                    'id' => 22,
                    'express_name' => '大洋物流快递',
                    'express_code' => 'DYWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:15:34',
                    'updated_at' => '2016-11-04 19:08:49',
                ),
            22 =>
                array (
                    'id' => 23,
                    'express_name' => 'EMS',
                    'express_code' => 'EMS',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:15:49',
                    'updated_at' => '2016-11-04 19:02:08',
                ),
            23 =>
                array (
                    'id' => 24,
                    'express_name' => '快捷速递',
                    'express_code' => 'FAST',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:16:06',
                    'updated_at' => '2016-11-04 19:08:55',
                ),
            24 =>
                array (
                    'id' => 25,
                    'express_name' => '飞豹快递',
                    'express_code' => 'FBKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:16:23',
                    'updated_at' => '2016-11-04 19:09:02',
                ),
            25 =>
                array (
                    'id' => 26,
                    'express_name' => 'FedEx联邦快递',
                    'express_code' => 'FEDEX',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:16:40',
                    'updated_at' => '2016-11-04 19:15:35',
                ),
            26 =>
                array (
                    'id' => 27,
                    'express_name' => '飞狐快递',
                    'express_code' => 'FHKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:16:58',
                    'updated_at' => '2016-11-04 19:15:39',
                ),
            27 =>
                array (
                    'id' => 28,
                    'express_name' => '飞康达',
                    'express_code' => 'FKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:17:14',
                    'updated_at' => '2016-11-04 19:15:43',
                ),
            28 =>
                array (
                    'id' => 29,
                    'express_name' => '飞远配送',
                    'express_code' => 'FYPS',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:17:37',
                    'updated_at' => '2016-11-04 19:15:46',
                ),
            29 =>
                array (
                    'id' => 30,
                    'express_name' => '凡宇速递',
                    'express_code' => 'FYSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:17:52',
                    'updated_at' => '2016-11-04 19:16:15',
                ),
            30 =>
                array (
                    'id' => 31,
                    'express_name' => '广东邮政',
                    'express_code' => 'GDEMS',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:18:07',
                    'updated_at' => '2016-11-04 19:16:19',
                ),
            31 =>
                array (
                    'id' => 32,
                    'express_name' => '冠达快递',
                    'express_code' => 'GDKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:18:21',
                    'updated_at' => '2016-11-04 19:16:23',
                ),
            32 =>
                array (
                    'id' => 33,
                    'express_name' => '挂号信',
                    'express_code' => 'GHX',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:18:40',
                    'updated_at' => '2016-11-04 19:16:27',
                ),
            33 =>
                array (
                    'id' => 34,
                    'express_name' => '港快速递',
                    'express_code' => 'GKSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:18:55',
                    'updated_at' => '2016-11-04 19:16:31',
                ),
            34 =>
                array (
                    'id' => 35,
                    'express_name' => '共速达',
                    'express_code' => 'GSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:19:11',
                    'updated_at' => '2016-11-04 19:16:34',
                ),
            35 =>
                array (
                    'id' => 36,
                    'express_name' => '广通速递',
                    'express_code' => 'GTKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:19:26',
                    'updated_at' => '2016-11-04 19:16:41',
                ),
            36 =>
                array (
                    'id' => 37,
                    'express_name' => '国通快递',
                    'express_code' => 'GTO',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:19:40',
                    'updated_at' => '2016-11-05 14:13:57',
                ),
            37 =>
                array (
                    'id' => 38,
                    'express_name' => '高铁速递',
                    'express_code' => 'GTSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:19:56',
                    'updated_at' => '2016-11-04 19:17:02',
                ),
            38 =>
                array (
                    'id' => 39,
                    'express_name' => '河北建华',
                    'express_code' => 'HBJH',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:20:14',
                    'updated_at' => '2016-11-04 19:17:06',
                ),
            39 =>
                array (
                    'id' => 40,
                    'express_name' => '汇丰物流',
                    'express_code' => 'HFWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:20:29',
                    'updated_at' => '2016-11-04 19:17:12',
                ),
            40 =>
                array (
                    'id' => 41,
                    'express_name' => '华航快递',
                    'express_code' => 'HHKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:20:48',
                    'updated_at' => '2016-11-04 19:17:16',
                ),
            41 =>
                array (
                    'id' => 42,
                    'express_name' => '天天快递',
                    'express_code' => 'HHTT',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:21:03',
                    'updated_at' => '2016-11-05 09:43:14',
                ),
            42 =>
                array (
                    'id' => 43,
                    'express_name' => '韩润物流',
                    'express_code' => 'HLKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:21:18',
                    'updated_at' => '2016-11-04 19:17:26',
                ),
            43 =>
                array (
                    'id' => 44,
                    'express_name' => '恒路物流',
                    'express_code' => 'HLWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:21:56',
                    'updated_at' => '2016-11-04 19:17:29',
                ),
            44 =>
                array (
                    'id' => 45,
                    'express_name' => '黄马甲快递',
                    'express_code' => 'HMJKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:22:12',
                    'updated_at' => '2016-11-04 19:17:34',
                ),
            45 =>
                array (
                    'id' => 46,
                    'express_name' => '海盟速递',
                    'express_code' => 'HMSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:22:27',
                    'updated_at' => '2016-11-04 19:17:40',
                ),
            46 =>
                array (
                    'id' => 47,
                    'express_name' => '天地华宇',
                    'express_code' => 'HOAU',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:22:42',
                    'updated_at' => '2016-11-04 19:17:45',
                ),
            47 =>
                array (
                    'id' => 48,
                    'express_name' => '华强物流',
                    'express_code' => 'hq568',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:22:55',
                    'updated_at' => '2016-11-04 19:17:56',
                ),
            48 =>
                array (
                    'id' => 49,
                    'express_name' => '华企快运',
                    'express_code' => 'HQKY',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:23:09',
                    'updated_at' => '2016-11-04 19:18:00',
                ),
            49 =>
                array (
                    'id' => 50,
                    'express_name' => '昊盛物流',
                    'express_code' => 'HSWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:23:23',
                    'updated_at' => '2016-11-04 19:18:03',
                ),
            50 =>
                array (
                    'id' => 51,
                    'express_name' => '百世汇通',
                    'express_code' => 'HTKY',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:23:37',
                    'updated_at' => '2016-11-05 09:43:26',
                ),
            51 =>
                array (
                    'id' => 52,
                    'express_name' => '户通物流',
                    'express_code' => 'HTWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:23:50',
                    'updated_at' => '2016-11-04 19:18:11',
                ),
            52 =>
                array (
                    'id' => 53,
                    'express_name' => '华夏龙物流',
                    'express_code' => 'HXLWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:24:03',
                    'updated_at' => '2016-11-04 19:18:15',
                ),
            53 =>
                array (
                    'id' => 54,
                    'express_name' => '好来运快递',
                    'express_code' => 'HYLSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:24:18',
                    'updated_at' => '2016-11-04 19:18:18',
                ),
            54 =>
                array (
                    'id' => 55,
                    'express_name' => '京东快递',
                    'express_code' => 'JD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:24:32',
                    'updated_at' => '2016-11-04 19:18:23',
                ),
            55 =>
                array (
                    'id' => 56,
                    'express_name' => '京广速递',
                    'express_code' => 'JGSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:24:51',
                    'updated_at' => '2016-11-04 19:18:38',
                ),
            56 =>
                array (
                    'id' => 57,
                    'express_name' => '九曳供应链',
                    'express_code' => 'JIUYE',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:25:05',
                    'updated_at' => '2016-11-04 19:18:43',
                ),
            57 =>
                array (
                    'id' => 58,
                    'express_name' => '佳吉快运',
                    'express_code' => 'JJKY',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:25:21',
                    'updated_at' => '2016-11-04 19:18:49',
                ),
            58 =>
                array (
                    'id' => 59,
                    'express_name' => '嘉里大通',
                    'express_code' => 'JLDT',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:25:35',
                    'updated_at' => '2016-11-04 19:19:32',
                ),
            59 =>
                array (
                    'id' => 60,
                    'express_name' => '捷特快递',
                    'express_code' => 'JTKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:25:48',
                    'updated_at' => '2016-11-04 19:19:36',
                ),
            60 =>
                array (
                    'id' => 61,
                    'express_name' => '急先达',
                    'express_code' => 'JXD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:26:02',
                    'updated_at' => '2016-11-04 19:19:39',
                ),
            61 =>
                array (
                    'id' => 62,
                    'express_name' => '晋越快递',
                    'express_code' => 'JYKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:26:14',
                    'updated_at' => '2016-11-04 19:19:43',
                ),
            62 =>
                array (
                    'id' => 63,
                    'express_name' => '加运美',
                    'express_code' => 'JYM',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:26:27',
                    'updated_at' => '2016-11-04 19:19:46',
                ),
            63 =>
                array (
                    'id' => 64,
                    'express_name' => '久易快递',
                    'express_code' => 'JYSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:26:43',
                    'updated_at' => '2016-11-04 19:19:49',
                ),
            64 =>
                array (
                    'id' => 65,
                    'express_name' => '佳怡物流',
                    'express_code' => 'JYWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:26:58',
                    'updated_at' => '2016-11-04 19:19:52',
                ),
            65 =>
                array (
                    'id' => 66,
                    'express_name' => '康力物流',
                    'express_code' => 'KLWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:27:13',
                    'updated_at' => '2016-11-04 19:19:57',
                ),
            66 =>
                array (
                    'id' => 67,
                    'express_name' => '快淘快递',
                    'express_code' => 'KTKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:27:30',
                    'updated_at' => '2016-11-04 19:20:09',
                ),
            67 =>
                array (
                    'id' => 68,
                    'express_name' => '快优达速递',
                    'express_code' => 'KYDSD',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:27:43',
                    'updated_at' => '2016-11-05 09:43:45',
                ),
            68 =>
                array (
                    'id' => 69,
                    'express_name' => '跨越速递',
                    'express_code' => 'KYWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:27:57',
                    'updated_at' => '2016-11-04 19:20:17',
                ),
            69 =>
                array (
                    'id' => 70,
                    'express_name' => '龙邦快递',
                    'express_code' => 'LB',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:28:10',
                    'updated_at' => '2016-11-04 19:20:22',
                ),
            70 =>
                array (
                    'id' => 71,
                    'express_name' => '联邦快递',
                    'express_code' => 'LBKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:28:24',
                    'updated_at' => '2016-11-04 19:20:28',
                ),
            71 =>
                array (
                    'id' => 72,
                    'express_name' => '蓝弧快递',
                    'express_code' => 'LHKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:28:39',
                    'updated_at' => '2016-11-04 19:20:31',
                ),
            72 =>
                array (
                    'id' => 73,
                    'express_name' => '联昊通速递',
                    'express_code' => 'LHT',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:28:52',
                    'updated_at' => '2016-11-04 19:20:35',
                ),
            73 =>
                array (
                    'id' => 74,
                    'express_name' => '乐捷递',
                    'express_code' => 'LJD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:29:08',
                    'updated_at' => '2016-11-04 19:20:42',
                ),
            74 =>
                array (
                    'id' => 75,
                    'express_name' => '立即送',
                    'express_code' => 'LJS',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:29:25',
                    'updated_at' => '2016-11-04 19:20:54',
                ),
            75 =>
                array (
                    'id' => 76,
                    'express_name' => '民邦速递',
                    'express_code' => 'MB',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:29:39',
                    'updated_at' => '2016-11-04 19:21:00',
                ),
            76 =>
                array (
                    'id' => 77,
                    'express_name' => '门对门',
                    'express_code' => 'MDM',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:29:53',
                    'updated_at' => '2016-11-05 09:44:03',
                ),
            77 =>
                array (
                    'id' => 78,
                    'express_name' => '民航快递',
                    'express_code' => 'MHKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:30:08',
                    'updated_at' => '2016-11-04 19:21:14',
                ),
            78 =>
                array (
                    'id' => 79,
                    'express_name' => '明亮物流',
                    'express_code' => 'MLWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:30:21',
                    'updated_at' => '2016-11-04 19:21:18',
                ),
            79 =>
                array (
                    'id' => 80,
                    'express_name' => '闽盛快递',
                    'express_code' => 'MSKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:30:35',
                    'updated_at' => '2016-11-04 19:21:24',
                ),
            80 =>
                array (
                    'id' => 81,
                    'express_name' => '能达速递',
                    'express_code' => 'NEDA',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:30:52',
                    'updated_at' => '2016-11-04 19:21:28',
                ),
            81 =>
                array (
                    'id' => 82,
                    'express_name' => '南京晟邦物流',
                    'express_code' => 'NJSBWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:31:11',
                    'updated_at' => '2016-11-04 19:21:31',
                ),
            82 =>
                array (
                    'id' => 83,
                    'express_name' => '平安达腾飞快递',
                    'express_code' => 'PADTF',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:31:24',
                    'updated_at' => '2016-11-04 19:21:35',
                ),
            83 =>
                array (
                    'id' => 84,
                    'express_name' => '陪行物流',
                    'express_code' => 'PXWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:31:38',
                    'updated_at' => '2016-11-04 19:21:38',
                ),
            84 =>
                array (
                    'id' => 85,
                    'express_name' => '全晨快递',
                    'express_code' => 'QCKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:31:53',
                    'updated_at' => '2016-11-04 19:21:41',
                ),
            85 =>
                array (
                    'id' => 86,
                    'express_name' => '全峰快递',
                    'express_code' => 'QFKD',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:32:07',
                    'updated_at' => '2016-11-05 09:44:14',
                ),
            86 =>
                array (
                    'id' => 87,
                    'express_name' => '全日通快递',
                    'express_code' => 'QRT',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:32:23',
                    'updated_at' => '2016-11-04 19:22:03',
                ),
            87 =>
                array (
                    'id' => 88,
                    'express_name' => '如风达',
                    'express_code' => 'RFD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:32:36',
                    'updated_at' => '2016-11-04 19:22:13',
                ),
            88 =>
                array (
                    'id' => 89,
                    'express_name' => '日昱物流',
                    'express_code' => 'RLWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:32:48',
                    'updated_at' => '2016-11-04 19:22:08',
                ),
            89 =>
                array (
                    'id' => 90,
                    'express_name' => '赛澳递',
                    'express_code' => 'SAD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:33:04',
                    'updated_at' => '2016-11-04 19:22:17',
                ),
            90 =>
                array (
                    'id' => 91,
                    'express_name' => '圣安物流',
                    'express_code' => 'SAWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:33:18',
                    'updated_at' => '2016-11-04 19:22:21',
                ),
            91 =>
                array (
                    'id' => 92,
                    'express_name' => '盛邦物流',
                    'express_code' => 'SBWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:33:34',
                    'updated_at' => '2016-11-04 19:22:47',
                ),
            92 =>
                array (
                    'id' => 93,
                    'express_name' => '山东海红',
                    'express_code' => 'SDHH',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:33:48',
                    'updated_at' => '2016-11-04 19:22:50',
                ),
            93 =>
                array (
                    'id' => 94,
                    'express_name' => '上大物流',
                    'express_code' => 'SDWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:34:07',
                    'updated_at' => '2016-11-04 19:22:54',
                ),
            94 =>
                array (
                    'id' => 95,
                    'express_name' => '顺丰快递',
                    'express_code' => 'SF',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:34:20',
                    'updated_at' => '2016-11-05 09:44:22',
                ),
            95 =>
                array (
                    'id' => 96,
                    'express_name' => '盛丰物流',
                    'express_code' => 'SFWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:34:37',
                    'updated_at' => '2016-11-04 19:23:03',
                ),
            96 =>
                array (
                    'id' => 97,
                    'express_name' => '上海林道货运',
                    'express_code' => 'SHLDHY',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:34:52',
                    'updated_at' => '2016-11-04 19:23:06',
                ),
            97 =>
                array (
                    'id' => 98,
                    'express_name' => '盛辉物流',
                    'express_code' => 'SHWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:35:06',
                    'updated_at' => '2016-11-04 19:23:10',
                ),
            98 =>
                array (
                    'id' => 99,
                    'express_name' => '穗佳物流',
                    'express_code' => 'SJWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:35:21',
                    'updated_at' => '2016-11-04 19:23:33',
                ),
            99 =>
                array (
                    'id' => 100,
                    'express_name' => '速通物流',
                    'express_code' => 'ST',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:35:35',
                    'updated_at' => '2016-11-05 09:44:45',
                ),
            100 =>
                array (
                    'id' => 101,
                    'express_name' => '申通快递',
                    'express_code' => 'STO',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:35:49',
                    'updated_at' => '2016-11-05 09:44:37',
                ),
            101 =>
                array (
                    'id' => 102,
                    'express_name' => '三态速递',
                    'express_code' => 'STSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:36:03',
                    'updated_at' => '2016-11-04 19:23:45',
                ),
            102 =>
                array (
                    'id' => 103,
                    'express_name' => '速尔快递',
                    'express_code' => 'SURE',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:36:16',
                    'updated_at' => '2016-11-05 09:44:31',
                ),
            103 =>
                array (
                    'id' => 104,
                    'express_name' => '山西红马甲',
                    'express_code' => 'SXHMJ',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:36:30',
                    'updated_at' => '2016-11-04 19:23:51',
                ),
            104 =>
                array (
                    'id' => 105,
                    'express_name' => '沈阳佳惠尔',
                    'express_code' => 'SYJHE',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:36:45',
                    'updated_at' => '2016-11-04 19:23:56',
                ),
            105 =>
                array (
                    'id' => 106,
                    'express_name' => '世运快递',
                    'express_code' => 'SYKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:37:02',
                    'updated_at' => '2016-11-04 19:24:01',
                ),
            106 =>
                array (
                    'id' => 107,
                    'express_name' => '通和天下',
                    'express_code' => 'THTX',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:37:16',
                    'updated_at' => '2016-11-04 19:24:04',
                ),
            107 =>
                array (
                    'id' => 108,
                    'express_name' => '唐山申通',
                    'express_code' => 'TSSTO',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:37:29',
                    'updated_at' => '2016-11-04 19:24:53',
                ),
            108 =>
                array (
                    'id' => 109,
                    'express_name' => '全一快递',
                    'express_code' => 'UAPEX',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:37:44',
                    'updated_at' => '2016-11-05 09:45:01',
                ),
            109 =>
                array (
                    'id' => 110,
                    'express_name' => '优速快递',
                    'express_code' => 'UC',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:37:59',
                    'updated_at' => '2016-11-05 09:45:07',
                ),
            110 =>
                array (
                    'id' => 111,
                    'express_name' => '万家物流',
                    'express_code' => 'WJWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:38:13',
                    'updated_at' => '2016-11-04 19:25:05',
                ),
            111 =>
                array (
                    'id' => 112,
                    'express_name' => '微特派',
                    'express_code' => 'WTP',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:38:28',
                    'updated_at' => '2016-11-04 19:25:09',
                ),
            112 =>
                array (
                    'id' => 113,
                    'express_name' => '万象物流',
                    'express_code' => 'WXWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:38:43',
                    'updated_at' => '2016-11-04 19:25:14',
                ),
            113 =>
                array (
                    'id' => 114,
                    'express_name' => '新邦物流',
                    'express_code' => 'XBWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:38:57',
                    'updated_at' => '2016-11-04 19:25:33',
                ),
            114 =>
                array (
                    'id' => 115,
                    'express_name' => '信丰快递',
                    'express_code' => 'XFEX',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:39:12',
                    'updated_at' => '2016-11-04 19:25:36',
                ),
            115 =>
                array (
                    'id' => 116,
                    'express_name' => '香港邮政',
                    'express_code' => 'XGYZ',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:39:30',
                    'updated_at' => '2016-11-04 19:25:41',
                ),
            116 =>
                array (
                    'id' => 117,
                    'express_name' => '祥龙运通',
                    'express_code' => 'XLYT',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:39:47',
                    'updated_at' => '2016-11-04 19:25:44',
                ),
            117 =>
                array (
                    'id' => 118,
                    'express_name' => '希优特',
                    'express_code' => 'XYT',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:40:03',
                    'updated_at' => '2016-11-04 19:25:48',
                ),
            118 =>
                array (
                    'id' => 119,
                    'express_name' => '源安达快递',
                    'express_code' => 'YADEX',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:40:17',
                    'updated_at' => '2016-11-04 19:25:52',
                ),
            119 =>
                array (
                    'id' => 120,
                    'express_name' => '邮必佳',
                    'express_code' => 'YBJ',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:40:30',
                    'updated_at' => '2016-11-04 19:25:56',
                ),
            120 =>
                array (
                    'id' => 121,
                    'express_name' => '远成物流',
                    'express_code' => 'YCWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:40:45',
                    'updated_at' => '2016-11-04 19:25:59',
                ),
            121 =>
                array (
                    'id' => 122,
                    'express_name' => '韵达快递',
                    'express_code' => 'YD',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:40:58',
                    'updated_at' => '2016-11-05 09:25:32',
                ),
            122 =>
                array (
                    'id' => 123,
                    'express_name' => '义达国际物流',
                    'express_code' => 'YDH',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:41:16',
                    'updated_at' => '2016-11-04 19:26:02',
                ),
            123 =>
                array (
                    'id' => 124,
                    'express_name' => '越丰物流',
                    'express_code' => 'YFEX',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:41:30',
                    'updated_at' => '2016-11-04 19:26:07',
                ),
            124 =>
                array (
                    'id' => 125,
                    'express_name' => '原飞航物流',
                    'express_code' => 'YFHEX',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:41:44',
                    'updated_at' => '2016-11-04 19:26:11',
                ),
            125 =>
                array (
                    'id' => 126,
                    'express_name' => '亚风快递',
                    'express_code' => 'YFSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:41:58',
                    'updated_at' => '2016-11-04 19:26:14',
                ),
            126 =>
                array (
                    'id' => 127,
                    'express_name' => '银捷速递',
                    'express_code' => 'YJSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:42:13',
                    'updated_at' => '2016-11-04 19:26:18',
                ),
            127 =>
                array (
                    'id' => 128,
                    'express_name' => '亿领速运',
                    'express_code' => 'YLSY',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:42:26',
                    'updated_at' => '2016-11-04 19:26:21',
                ),
            128 =>
                array (
                    'id' => 129,
                    'express_name' => '英脉物流',
                    'express_code' => 'YMWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:42:39',
                    'updated_at' => '2016-11-04 19:26:25',
                ),
            129 =>
                array (
                    'id' => 130,
                    'express_name' => '亿顺航',
                    'express_code' => 'YSH',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:42:54',
                    'updated_at' => '2016-11-04 19:26:29',
                ),
            130 =>
                array (
                    'id' => 131,
                    'express_name' => '音素快运',
                    'express_code' => 'YSKY',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:43:07',
                    'updated_at' => '2016-11-04 19:26:32',
                ),
            131 =>
                array (
                    'id' => 132,
                    'express_name' => '易通达',
                    'express_code' => 'YTD',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:43:20',
                    'updated_at' => '2016-11-05 09:45:39',
                ),
            132 =>
                array (
                    'id' => 133,
                    'express_name' => '一统飞鸿',
                    'express_code' => 'YTFH',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:43:35',
                    'updated_at' => '2016-11-04 19:26:40',
                ),
            133 =>
                array (
                    'id' => 134,
                    'express_name' => '运通快递',
                    'express_code' => 'YTKD',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:43:50',
                    'updated_at' => '2016-11-05 09:45:31',
                ),
            134 =>
                array (
                    'id' => 135,
                    'express_name' => '圆通速递',
                    'express_code' => 'YTO',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:44:04',
                    'updated_at' => '2016-11-05 09:45:24',
                ),
            135 =>
                array (
                    'id' => 136,
                    'express_name' => '宇鑫物流',
                    'express_code' => 'YXWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:44:21',
                    'updated_at' => '2016-11-04 19:27:08',
                ),
            136 =>
                array (
                    'id' => 137,
                    'express_name' => '邮政平邮/小包',
                    'express_code' => 'YZPY',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:44:34',
                    'updated_at' => '2016-11-05 09:46:13',
                ),
            137 =>
                array (
                    'id' => 138,
                    'express_name' => '增益快递',
                    'express_code' => 'ZENY',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:44:48',
                    'updated_at' => '2016-11-04 19:27:17',
                ),
            138 =>
                array (
                    'id' => 139,
                    'express_name' => '汇强快递',
                    'express_code' => 'ZHQKD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:45:02',
                    'updated_at' => '2016-11-04 19:27:21',
                ),
            139 =>
                array (
                    'id' => 140,
                    'express_name' => '宅急送',
                    'express_code' => 'ZJS',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:45:16',
                    'updated_at' => '2016-11-05 09:45:50',
                ),
            140 =>
                array (
                    'id' => 141,
                    'express_name' => '芝麻开门',
                    'express_code' => 'ZMKM',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:45:30',
                    'updated_at' => '2016-11-04 19:27:53',
                ),
            141 =>
                array (
                    'id' => 142,
                    'express_name' => '中睿速递',
                    'express_code' => 'ZRSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:45:45',
                    'updated_at' => '2016-11-04 19:27:57',
                ),
            142 =>
                array (
                    'id' => 143,
                    'express_name' => '众通快递',
                    'express_code' => 'ZTE',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:45:58',
                    'updated_at' => '2016-11-04 19:28:01',
                ),
            143 =>
                array (
                    'id' => 144,
                    'express_name' => '中铁快运',
                    'express_code' => 'ZTKY',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:46:12',
                    'updated_at' => '2016-11-04 19:28:06',
                ),
            144 =>
                array (
                    'id' => 145,
                    'express_name' => '中通速递',
                    'express_code' => 'ZTO',
                    'is_open' => '1',
                    'created_at' => '2016-07-06 14:46:27',
                    'updated_at' => '2016-11-05 09:25:20',
                ),
            145 =>
                array (
                    'id' => 146,
                    'express_name' => '中铁物流',
                    'express_code' => 'ZTWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:46:42',
                    'updated_at' => '2016-11-04 19:28:12',
                ),
            146 =>
                array (
                    'id' => 147,
                    'express_name' => '中天万运',
                    'express_code' => 'ZTWY',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:46:56',
                    'updated_at' => '2016-11-04 19:28:16',
                ),
            147 =>
                array (
                    'id' => 148,
                    'express_name' => '中外运速递',
                    'express_code' => 'ZWYSD',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:47:12',
                    'updated_at' => '2016-11-04 19:28:21',
                ),
            148 =>
                array (
                    'id' => 149,
                    'express_name' => '中邮物流',
                    'express_code' => 'ZYWL',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:47:28',
                    'updated_at' => '2016-11-04 19:28:25',
                ),
            149 =>
                array (
                    'id' => 150,
                    'express_name' => '郑州建华',
                    'express_code' => 'ZZJH',
                    'is_open' => '0',
                    'created_at' => '2016-07-06 14:47:43',
                    'updated_at' => '2016-11-04 19:28:28',
                ),
            150 =>
                array (
                    'id' => 151,
                    'express_name' => '德邦物流到付',
                    'express_code' => 'DBWLDF',
                    'is_open' => '1',
                    'created_at' => '2016-11-04 10:47:40',
                    'updated_at' => '2016-11-05 09:26:17',
                ),
            151 =>
                array (
                    'id' => 152,
                    'express_name' => '德邦送货上门到付',
                    'express_code' => 'DBSHSMDF',
                    'is_open' => '1',
                    'created_at' => '2016-11-04 10:47:56',
                    'updated_at' => '2016-11-05 09:26:21',
                ),
            152 =>
                array (
                    'id' => 153,
                    'express_name' => '专线到付',
                    'express_code' => 'ZXDF',
                    'is_open' => '1',
                    'created_at' => '2016-11-04 10:48:26',
                    'updated_at' => '2016-11-05 09:25:49',
                ),
        ));


    }
}