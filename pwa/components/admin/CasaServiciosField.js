// src/FacturaPagosField.js
import {React} from 'react';
import {Table, TableBody, TableCell, TableHead, TableRow, Typography} from '@mui/material';
import {
  Datagrid,
  ReferenceArrayField,
  ReferenceField,
  ReferenceManyField, ShowButton,
  TextField,
  useRecordContext
} from 'react-admin';
import {ShowGuesser} from "@api-platform/admin";
import {Link} from "react-router-dom";


const PdfViewerField = ({source}) => {
  const record = useRecordContext();

  const servicios = record && record["servicios"];

  console.log(record);

  if (!servicios) {
    return <Typography variant="body2">No Hay Servicios Asociados!</Typography>;
  }

  return (
    <Table size="small">
      <TableHead>
        <TableRow>
          <TableCell>Nombre</TableCell>
          <TableCell>Fecturas Impagas</TableCell>
          <TableCell>Deuda</TableCell>
        </TableRow>
      </TableHead>
      <TableBody>
        {
          Object.entries(servicios).map(([key, value]) => (

            <TableRow key={key}>
              <TableCell>{key}</TableCell>
              <TableCell>
                {
                  Object.entries(value.facturas).map(([key2, value2]) => {
                      const id = value2['@id'];

                      return (
                        <div key={key2}>
                          <ShowButton resource="facturas" basePath="/facturas" record={{id}}/>
                        </div>
                      )
                    }
                  )
                }

              </TableCell>
              <TableCell>{value.deuda}</TableCell>
            </TableRow>
          ))
        }
      </TableBody>
    </Table>
  )

};

export default PdfViewerField;
