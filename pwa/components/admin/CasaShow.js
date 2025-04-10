// src/CasaShow.js
import React from 'react';
import {SimpleShowLayout, Tab, TabbedShowLayout} from 'react-admin';

import CasaServiciosField from './CasaServiciosField';

import {
  ShowGuesser,
  FieldGuesser,
} from '@api-platform/admin';

const CasaShow = (props) => (
  <ShowGuesser {...props}>
    <SimpleShowLayout>

      <TabbedShowLayout>
        <Tab label="Detalles">
          <FieldGuesser source="direccion" />
          <FieldGuesser source="propietario" />
        </Tab>
        <Tab label="Servicios">
          <CasaServiciosField source="servicios" />
        </Tab>
      </TabbedShowLayout>
    </SimpleShowLayout>
  </ShowGuesser>
);

export default CasaShow;
