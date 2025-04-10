// src/FacturaCreate.js
import React from 'react';
import {FileField, FileInput} from 'react-admin';


import {
  CreateGuesser, InputGuesser,
} from '@api-platform/admin';

const FacturaCreate = (props) => (
  <CreateGuesser >
    <InputGuesser source="casa" />
    <InputGuesser source="servicio" />
    <InputGuesser source="fechaEmision" />
    <InputGuesser source="pagos" />
    <InputGuesser source="monto" />

    <FileInput source="file">
      <FileField source="src" title="title" />
    </FileInput>


  </CreateGuesser>
);
export default FacturaCreate;
