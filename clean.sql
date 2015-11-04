SELECT * FROM impulse.appointments;

delete from accounts_receivable;
delete from payments;
delete from invoices;
delete from receipts;
update appointments set fk_appointment_status_id = 4;
delete from sales_product_items;
delete from sales_services_items;
delete from sales;

