frappe.ui.form.on('Daily Report', {
    refresh: function(frm) {
        frm.add_custom_button(__('Print Report'), function() {
            var date = frm.doc.date;
            if (!date) {
                frappe.msgprint(__('Please select a date first.'));
                return;
            }
            var url = '/api/method/retail_shop.retail_shop.doctype.daily_report.daily_report.generate_pdf?date=' + date;
            window.open(url);
        });
    }
});