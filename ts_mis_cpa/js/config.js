//占位符查找
var placeholder = ['DMAC_UPPER', 'IDFA', 'MD5_MAC', 'OPEN_UDID_LOWER', 'DMAC_PURE_NUM', 'DMAC_LOWER', 'DMAC_PURE_NUM_LOWER', 'NOCOLONIDFA', 'NOCOLONIDFA_LOWER', 'IDFA_LOWER', 'OPEN_UDID', 'TIMESTAMP', 'MAC_OR_IDFA'];

//所有类型下的占位符
var placeholderType = {
		'dmac':['DMAC_UPPER', 'MD5_MAC', 'DMAC_LOWER', 'DMAC_PURE_NUM', 'DMAC_PURE_NUM_LOWER'],
		'ifa':['IDFA', 'NOCOLONIDFA', 'NOCOLONIDFA_LOWER', 'IDFA_LOWER'],
		'oid':['OPEN_UDID_LOWER', 'OPEN_UDID']
}

//友情提示
var hintcon = ['Alt + 1 => &ltDMAC_UPPER&gt; 大写带冒号的MAC地址',
	       'Alt + 2 => &ltIDFA&gt; 大写的带分隔符的IDFA',
	       'Alt + 3 => &ltOPEN_UDID_LOWER&gt; 小写的OpenUDID',
	       'Alt + 4 => &ltMD5_MAC&gt; 经过MD5加密的MAC地址',
	       'Alt + 5 => &ltDMAC_PURE_NUM&gt; 大写不带冒号的MAC地址',
	       'Alt + 6 => &ltDMAC_PURE_NUM_LOWER&gt; 小写不带冒号的MAC地址',
	       'Alt + 7 => &ltDMAC_LOWER&gt; 小写带冒号的MAC地址',
	       'Alt + 8 => &ltNOCOLONIDFA&gt; 大写的不带分隔符的IDFA',
	       'Alt + 9 => &ltNOCOLONIDFA_LOWER&gt; 小写的不带分隔符的IDFA',
	       'Alt + 0 => &ltIDFA_LOWER&gt; 小写的带分隔符的IDFA',
	       'Alt + - => &ltOPEN_UDID&gt; OpenUDID',
	       'Alt + t => &ltTIMESTAMP&gt; 时间戳',
	       'Alt + m => &ltMAC_OR_IDFA&gt; 当mac有效的时候为mac，无效的时候为idfa',
	       'Alt + s => &lt_SIGN&gt; 自定义签名',
             ]

//积分墙仿真接口测试链接
var offerWallTest = {
    link : '',
    field : ''
};

