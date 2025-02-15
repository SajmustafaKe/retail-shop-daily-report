import frappe
from frappe.model.document import Document

class DailyReport(Document):
    pass

@frappe.whitelist()
def get_daily_report(date):
    sales = frappe.db.sql("""SELECT branch, amount FROM `tabSales` WHERE date=%s""", (date,))
    bank_balances = frappe.db.sql("""SELECT balance FROM `tabBankBalances` WHERE date=%s""", (date,))
    accounts_payable = frappe.db.sql("""SELECT amount FROM `tabAccountsPayable` WHERE date=%s""", (date,))
    accounts_receivable = frappe.db.sql("""SELECT amount FROM `tabAccountsReceivable` WHERE date=%s""", (date,))
    posted_cheques_released = frappe.db.sql("""SELECT amount FROM `tabPostedCheques` WHERE date=%s AND type='released'""", (date,))
    posted_cheques_received = frappe.db.sql("""SELECT amount FROM `tabPostedCheques` WHERE date=%s AND type='received'""", (date,))
    matters_arising = frappe.db.sql("""SELECT description FROM `tabMattersArising` WHERE date=%s""", (date,))
    
    return {
        "sales": sales,
        "bank_balances": bank_balances,
        "accounts_payable": accounts_payable,
        "accounts_receivable": accounts_receivable,
        "posted_cheques_released": posted_cheques_released,
        "posted_cheques_received": posted_cheques_received,
        "matters_arising": matters_arising
    }

@frappe.whitelist()
def generate_pdf(date):
    report_data = get_daily_report(date)
    pdf_data = frappe.render_template("templates/daily_report.html", report_data)
    
    pdf = frappe.utils.pdf.get_pdf(pdf_data)
    
    frappe.local.response.filename = f"daily_report_{date}.pdf"
    frappe.local.response.filecontent = pdf
    frappe.local.response.type = "download"