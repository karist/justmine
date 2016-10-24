(function ( $ ) {
    var extractItem = function (subMenuItems) {
        if (subMenuItems) {
            var arr = [];
            for (var i = 0; i < subMenuItems.length; i++) {
                if (typeof subMenuItems[i] != null && typeof subMenuItems[i] === 'object') {
                    var found = extractItem(subMenuItems[i].subcol);
                    arr = arr.concat(found);
                } else {
                    arr.push(subMenuItems[i]);
                }
            }
            return arr;
        }
    };    
 
    $.fn.jsonTable = function( options ) {
        var settings = $.extend({
            head: [],
            json:[]
        }, options, { table: this } );
        
        table = this;
        
        table.data("settings",settings);
        
        if (table.find("thead").length == 0) {
            table.append($("<thead></thead>").append("<tr class='head'></tr><tr class='child'></tr><tr class='subchild'></tr><tr class='subsubchild'></tr><tr class='lastchild'></tr><tr class='nomor'></tr>"));
        }
        
        if (table.find("thead").find("tr").length == 0) {
            table.find("thead").append("<tr></tr>");
        }
            
        if (table.find("tbody").length == 0) {
            table.append($("<tbody></tbody>"));
        }

        // if (table.find("tfoot").length == 0) {
        //     table.append($("<tfoot></tfoot>"));
        // }
        
        $.each(settings.head, function(i, header) {
            var depth = 5;
            if(typeof header == "object"){
                // obj_len(header);
                // var len, len2, len3, len4, len5 = 0;
                table.find("thead").find(".head").append("<th colspan = '"+obj_len(header)+"'>"+header.name+"</th>");
                $.each(header.subcol, function(j, child){
                    if(typeof child == "object"){
                        table.find("thead").find(".child").append("<th colspan = '"+obj_len(child)+"'>"+child.name+"</th>");
                        $.each(child.subcol, function(k, subchild){
                            if(typeof subchild == "object"){
                                table.find("thead").find(".subchild").append("<th colspan = '"+obj_len(subchild)+"'>"+subchild.name+"</th>");
                                $.each(subchild.subcol, function(l, subsubchild){
                                    if(typeof subsubchild == "object"){
                                        table.find("thead").find(".subsubchild").append("<th colspan = '"+obj_len(subsubchild)+"'>"+subsubchild.name+"</th>");
                                        $.each(subsubchild.subcol, function(m, lastchild){
                                            table.find("thead").find(".lastchild").append("<th>"+lastchild+"</th>");
                                        });
                                    } else {
                                        table.find("thead").find(".subsubchild").append("<th rowspan='"+(depth-3)+"'>"+subsubchild+"</th>");
                                    }
                                });
                            } else {
                                table.find("thead").find(".subchild").append("<th rowspan='"+(depth-2)+"'>"+subchild+"</th>");
                            }
                        });
                    } else {
                        table.find("thead").find(".child").append("<th rowspan='"+(depth-1)+"'>"+child+"</th>");
                    }
                });
            } else {
                table.find("thead").find(".head").append("<th rowspan ='"+depth+"'>"+header+"</th>");
            }
        });

        // var no_len = settings.json.length;
        var test = extractItem(settings.json);
        for(var no = 1; no <= test.length; no++){
            table.find("thead").find(".nomor").append("<th>("+no+")</th>");
            // table.find("tfoot").append("<td></td>");
        }

        return table;
    };

    function obj_len(obj){
        var len = 0;
        for(var a = 0; a < obj.subcol.length; a++){
            var child = obj.subcol[a];
            if(typeof child == "object"){
                for(var b = 0; b < child.subcol.length; b++){
                    var sub = child.subcol[b];
                    if(typeof sub == "object"){
                        for(var c = 0; c < sub.subcol.length; c++){
                            var cosub = sub.subcol[c];
                            // if(typeof cosub == "object"){
                            //     alert(cosub.subcol.name +": " +cosub.subcol.length);
                            // } else {
                                // alert(cosub + " " + cosub.length);
                                len += 1;
                            // }
                        }
                    } else {
                        // alert(sub +": 1");
                        len += 1;
                    }
                }
            } else {
                // alert(child + ": 1");
                len += 1;
            }
        }
        return len;
    }

    $.fn.jsonTableUpdate = function( options ){
        var opt = $.extend({
            source: undefined,
            rowClass: undefined,
            callback: undefined
        }, options );
        var settings = this.data("settings");

        if(typeof opt.source == "string")
        {
            $.get(opt.source, function(data) {
                $.fn.updateFromObj(data,settings,opt.rowClass, opt.callback);
            });
        }
        else if(typeof opt.source == "object")
        {
            $.fn.updateFromObj(opt.source,settings, opt.rowClass, opt.callback);
        }
    }

    $.fn.updateFromObj = function(obj,settings,rowClass, callback){
        settings.table.find("tbody").empty();
        $.each(obj, function(i,line) {
            var tableRow = $("<tr></tr>").addClass(rowClass);
            var test = extractItem(settings.json);
            $.each(test, function(j, identity) {
                if(identity == '*') {
                    tableRow.append($("<td>"+(i+1)+"</td>"));
                }
                else {
                    tableRow.append($("<td>" + line[this] + "</td>"));
                }
            });
            settings.table.append(tableRow);
        });
        
        
        if (typeof callback === "function") {
            callback();
        }
        
        $(window).trigger('resize');
    }
 
}( jQuery ));
 
