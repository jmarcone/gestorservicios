// src/FacturaEdit.js
import React from 'react';
import {FileField, FileInput} from 'react-admin';


import {
 EditGuesser, InputGuesser,
} from '@api-platform/admin';

const FacturaEdit = (props) => (
  <EditGuesser >
    <InputGuesser source="casa" />
    <InputGuesser source="servicio" />
    <InputGuesser source="fechaEmision" />
    <InputGuesser source="pagos" />
    <InputGuesser source="monto" />

    <FileInput source="file">
      <FileField source="src" title="title" />
    </FileInput>


  </EditGuesser>
);
export default FacturaEdit;
