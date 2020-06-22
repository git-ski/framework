/* Japanese initialisation for the jQuery UI date picker plugin. */
/* Written by Kentaro SATO (kentaro@ranvis.com). */
( function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define( [ "../widgets/datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.fn.datepicker );
	}
}( function( datepicker ) {

  datepicker.dates['ja'] = {
    days: [ "日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日" ],
    daysShort: [ "日","月","火","水","木","金","土" ],
    daysMin: [ "日","月","火","水","木","金","土" ],
    months: [ "1月","2月","3月","4月","5月","6月",
    "7月","8月","9月","10月","11月","12月" ],
    monthsShort: [ "1月","2月","3月","4月","5月","6月",
	"7月","8月","9月","10月","11月","12月" ],
    today: "今日",
    clear: "Clear",
    format: "yyyy/mm/dd",
    titleFormat: "yyyy/mm", /* Leverages same syntax as 'format' */
    weekStart: 0
};
datepicker.defaults.language = 'ja'
} ) );
