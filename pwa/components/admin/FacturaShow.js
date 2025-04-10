// src/FacturaShow.js
import React from 'react';
import {SimpleShowLayout, Tab, TabbedShowLayout} from 'react-admin';
import PdfViewerField from './PdfViewerField';

import {
  ShowGuesser,
  FieldGuesser,
} from '@api-platform/admin';
import FacturaPagosField from "./FacturaPagosField";

const FacturaShow = (props) => (
  <ShowGuesser {...props}>
    <SimpleShowLayout>
      <TabbedShowLayout>
        <Tab label="Detalles">
          <FieldGuesser source="casa" />
          <FieldGuesser source="servicio" />
          <FieldGuesser source="monto" />
          <FieldGuesser source="saldo" />
          <FieldGuesser source="isPaid" />
          <FieldGuesser source="fechaEmision" />
        </Tab>
        <Tab label="Factura">
          <PdfViewerField source="contentUrl" />
        </Tab>
        <Tab label="Pagos">
          <FacturaPagosField source="contentUrl" />
        </Tab>
      </TabbedShowLayout>
    </SimpleShowLayout>
  </ShowGuesser>
);

export default FacturaShow;
