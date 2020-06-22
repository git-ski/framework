(function ($) {
    var listManager = window.listManager || {};

    if (!listManager.initFormSearch) {
        listManager.initFormSearch = function () {
            if (!jQuery.fn.datepicker) {
                return false;
            }
            var datepickerConfig = {
                autoclose: true,
                todayHighlight: true,
                format: "yyyy-mm-dd",
                language: 'ja'
            }
            jQuery(".datepicker-autoclose").datepicker(datepickerConfig);

            jQuery(".datepicker-add").on('click', function () {
                jQuery(".datepicker-autoclose").datepicker(datepickerConfig);
            });
        }
    }

    if (!listManager.getCollector) {
        listManager.getCollector = function () {
            return {
                data: {},
                collect: function (name, value) {
                    name = name.split('.');
                    this.data = this._collect(name, value, this.data);
                },
                _collect: function (name, value, data) {
                    var _name = name[0];
                    if (name.length > 1) {
                        var rest = name.slice(1);
                        if (rest[0]) {
                            data[_name] = data[_name] || {};
                        } else {
                            data[_name] = data[_name] || [];
                        }
                        data[_name] = this._collect(rest, value, data[_name]);
                    } else {
                        if (_name) {
                            data[_name] = value;
                        } else {
                            data.push(value);
                        }
                    }
                    return data;
                }
            }
        }
    }

    if (!$('.dataTables').size()) {
        return false;
    }

    var meta = $('.dataTables').data();
    var loader = $('<div class="text-center"><div class="preloader pl-size-xl"><div class="spinner-layer"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div>');


    if (!listManager.search) {
        listManager.search = function (pageclick) {
            //
            var table = $('.dataTables');
            table.fadeTo("fast", 0.5);
            table.before(loader);
            var collector = listManager.getCollector();
            $("#" + meta.form).serializeArray().map(function (item) {
                item.name = item.name.replace(/]/g, '').replace(/\[/g, '.');
                collector.collect(item.name, item.value);
            });
            var page = 1;
            if (pageclick) {
                page = pageclick;
            }
            var index = 0;
            var order = [];
            $("[data-sort]", table).each(function (_, sorter) {
                var sorter = $(sorter);
                var name = 'sorter.' + sorter.data("sort");
                var value = sorter.hasClass("sorting_asc") ? 'asc' : sorter.hasClass("sorting_desc") ? 'desc' : null;
                if (value) {
                    collector.collect(name, value);
                    order.push([index,value]);
                }
                index++;
            });
            //
            $.ajax({
                url : meta.api,
                type : "GET",
                dataType : "json",
                data : {
                    page: page,
                    condition: collector.data[meta.fieldset] || [],
                    sort: collector.data['sorter']
                }
            }).then(function (response) {
                if (response.success) {
                    if (meta.replace) {
                        var searchbox = $('<div>' + response.data.content + '</div>');
                        $(meta.replace).replaceWith($(meta.replace, searchbox));
                        listManager.initDataTable(order);
                    } else {
                        var bgTitle = $(".bg-title");
                        bgTitle.detach();
                        var replace = $(response.data.content);
                        listManager.initDataTable(order, replace);
                        $(meta.wrapper).replaceWith(replace);
                        $(".bg-title", replace).replaceWith(bgTitle);
                        listManager.initFormSearch();
                    }
                } else {
                    alert('失敗');
                }
                table.fadeTo("fast", 1);
                loader.detach();
            }).fail(function () {
                alert('失敗');
                table.fadeTo("fast", 1);
                loader.detach();
            });
            //
        }
    }

    if (!listManager.initOrderBy) {
        listManager.initOrderBy = function () {
            var table = $('.dataTables');
            var orderData = table.data('orderby');
            var index = 0;
            var order = [];
            if (typeof orderData === 'object' && orderData !== null) {
                $("[data-sort]", table).each(function (_, sorter) {
                    var sorter = $(sorter);
                    var sortName = $(sorter).data('sort');
                    if (sortName && orderData.hasOwnProperty(sortName)) {
                        order.push([index, orderData[sortName]]);
                    }
                    index++;
                });
            }
            return order;
        }
    }


    if (!listManager.initDataTable) {
        listManager.initDataTable = function (order, content) {
            content = content || document;
            var inited = false;
            var disableSort = {
                targets: [],
                orderable: false,
            }
            $(".dataTables th", content).each(function (idx, th) {
                if (!$(th).data('sort')) {
                    disableSort.targets.push(idx);
                }
            });
            $('.dataTables', content).dataTable( {
                responsive: true,
                order: order,
                dom: 'B',
                language: {
                    "emptyTable": "該当する情報がありません。"
                },
                drawCallback: function(settings) {
                    if (inited) {
                        listManager.search(1);
                    }
                    inited = true;
                },
                columnDefs: [
                    disableSort
                ]
            });
            $("[name=submit]", content).click(function () {
                listManager.search(1);
                return false;
            });
            $(".pagination a", content).click(function () {
                match = this.search.match(/page=(\d+)/);
                if (match) {
                    listManager.search(match[1]);
                }
                return false;
            })
        }
    }
    listManager.initDataTable(listManager.initOrderBy());
    listManager.initFormSearch();
    window.listManager = listManager;
})(jQuery);