// src/FacturaPagosField.js
import {React} from 'react';
import {Table, TableBody, TableCell, TableHead, TableRow, Typography} from '@mui/material';
import {useRecordContext} from 'react-admin';

const PdfViewerField = ({source}) => {
  const record = useRecordContext();

  const pagos = record && record["pagos"];

  console.log(record);

  if (!pagos) {
    return <Typography variant="body2">No Hay Pagos!</Typography>;
  }

  return (
    <Table size="small">
      <TableHead>
        <TableRow>
          <TableCell>Fecha</TableCell>
          <TableCell>Monto</TableCell>
        </TableRow>
      </TableHead>
      <TableBody>
        {record.pagos.map((pago) => (
          <TableRow key={pago.id}>
            <TableCell>{pago.fechaPago}</TableCell>
            <TableCell>{pago.deuda}</TableCell>
          </TableRow>
        ))}
      </TableBody>
    </Table>
  )

};

export default PdfViewerField;
