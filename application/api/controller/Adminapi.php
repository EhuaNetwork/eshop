<?php


namespace app\api\controller;


use app\admin\controller\Common;
use think\Controller;

class Adminapi extends Common
{
    public function getmenu()
    {
        $admPath = $this->admPath;
        $data = [
            "homeInfo" => [
                "title" => "首页",
                "href" => url($admPath . '/index/controll')
            ],
            "logoInfo" => [
                "title" => "ESHOP",
                "image" => "/favicon.ico",
                "href" => ""
            ],
            "menuInfo" => [
                [
                    "title" => "系统设置",
                    "icon" => "fa fa-address-book",
                    "href" => "",
                    "target" => "_self",
                    "child" => [
                        [
                            "title" => "站点配置",
                            "href" => "",
                            "icon" => "fa fa-home",
                            "target" => "_self",
                            "child" => [
                                [
                                    "title" => "网站设置",
                                    "href" => url($admPath . '/index/set'),
                                    "icon" => "fa fa-tachometer",
                                    "target" => "_self"
                                ]
                            ]
                        ],
                        [
                            "title" => "第三方配置",
                            "href" => "",
                            "icon" => "fa fa-home",
                            "target" => "_self",
                            "child" => [
                                [
                                    "title" => "邮件配置",
                                    "href" => url($admPath . '/api/mail'),
                                    "icon" => "fa fa-tachometer",
                                    "target" => "_self"
                                ],
                                [
                                    "title" => "短信配置",
                                    "href" => url($admPath . '/api/sms'),
                                    "icon" => "fa fa-tachometer",
                                    "target" => "_self"
                                ],
                                [
                                    "title" => "支付配置",
                                    "href" => url($admPath . '/api/pay'),
                                    "icon" => "fa fa-tachometer",
                                    "target" => "_self"
                                ],
                                [
                                    "title" => "登录配置",
                                    "href" => url($admPath . '/api/login'),
                                    "icon" => "fa fa-tachometer",
                                    "target" => "_self"
                                ]
                            ]
                        ],[
                            "title" => "权限设置",
                            "href" => "",
                            "icon" => "fa fa-home",
                            "target" => "_self",
                            "child" => [
                                [
                                    "title" => "管理员列表",
                                    "href" => url($admPath . '/auth/index'),
                                    "icon" => "fa fa-tachometer",
                                    "target" => "_self"
                                ],
                                [
                                    "title" => "权限组",
                                    "href" => url($admPath . '/auth/type'),
                                    "icon" => "fa fa-tachometer",
                                    "target" => "_self"
                                ]
                            ]
                        ],[
                            "title" => "配送地区",
                            "href" => "",
                            "icon" => "fa fa-home",
                            "target" => "_self",
                            "child" => [
                                [
                                    "title" => "地区管理",
                                    "href" => url($admPath . '/address/index'),
                                    "icon" => "fa fa-tachometer",
                                    "target" => "_self"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "title" => "会员管理",
                    "icon" => "fa fa-lemon-o",
                    "href" => "#",
                    "target" => "_self",
                    "child" => [

                        [
                            "title" => "会员管理",
                            "href" => url($admPath . '/user/index'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "会员等级",
                            "href" => url($admPath . '/user/lv'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "等级规则",
                            "href" => url($admPath . '/user/set'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "站内信",
                            "href" => url($admPath . '/user/send'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ]

                    ]
                ],
                [
                    "title" => "商品管理",
                    "icon" => "fa fa-slideshare",
                    "href" => "#",
                    "target" => "_self",
                    "child" => [
                        [
                            "title" => "商品管理",
                            "href" => url($admPath . '/shop/index'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "品牌分类",
                            "href" => url($admPath . '/shopbrand/index'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "商品分类",
                            "href" => url($admPath . '/shoptype/index'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "规格管理",
                            "href" => url($admPath . '/shopstipulate/index'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ]
                    ]
                ],
                [
                    "title" => "店铺管理",
                    "icon" => "fa fa-slideshare",
                    "href" => "#",
                    "target" => "_self",
                    "child" => [
                        [
                            "title" => "店铺管理",
                            "href" => url($admPath . '/server/index'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "店铺等级",
                            "href" => url($admPath . '/server/lv'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "店铺分类",
                            "href" => url($admPath . '/server/type'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "提现管理",
                            "href" => url($admPath . '/server/tixian'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ]
                    ]
                ]
                ,
                [
                    "title" => "交易管理",
                    "icon" => "fa fa-slideshare",
                    "href" => "#",
                    "target" => "_self",
                    "child" => [
                        [
                            "title" => "订单管理",
                            "href" => url($admPath . '/order/index'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "退款管理",
                            "href" => url($admPath . '/order/refund'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "退货管理",
                            "href" => url($admPath . '/order/sales'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "评价管理",
                            "href" => url($admPath . '/order/appraise'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ],  [
                            "title" => "投诉管理",
                            "href" => url($admPath . '/order/complain'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ]
                    ]
                ],
                [
                    "title" => "插件管理",
                    "icon" => "fa fa-slideshare",
                    "href" => "#",
                    "target" => "_self",
                    "child" => [
                        [
                            "title" => "插件管理",
                            "href" => url($admPath . '/index/index'),
                            "icon" => "fa fa-tachometer",
                            "target" => "_self"
                        ]
                    ]
                ]
            ]
        ];


        return json($data);
    }
}