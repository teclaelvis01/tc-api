# ************************************************************
# Query para saber el importe acumulado del mes anterior 
# a la fecha de baja de un determinado usuario
# Subscriptor de prueba con ID 1
# ************************************************************

SELECT SUM(c.amount) accumulated_amount  FROM collections AS c
INNER JOIN subscriptors AS s ON s.id = c.subscriptor_id
WHERE c.subscriptor_id = 1
AND c.result = 'OK'
AND c.created_at < s.created_at
