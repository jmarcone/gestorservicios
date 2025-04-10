import {CreateGuesser, HydraAdmin, ResourceGuesser } from "@api-platform/admin";
// import {FileField, FileInput} from 'react-admin';


import FacturaShow from './FacturaShow';
import FacturaEdit from './FacturaEdit';
import FacturaCreate from './FacturaCreate';
import CasaShow from './CasaShow';

// const MediaObjectsCreate = () => (
//   <CreateGuesser >
//     <FileInput source="file">
//       <FileField source="src" title="title" />
//     </FileInput>
//   </CreateGuesser>
// );



const App = () => (
  <HydraAdmin
    entrypoint={window.origin}
    title="API Platform admin"
  >
      {/*<ResourceGuesser name="media_objects" create={MediaObjectsCreate} />*/}
      <ResourceGuesser name="casas" show={CasaShow}/>
      <ResourceGuesser name="facturas" create={FacturaCreate} edit={FacturaEdit} show={FacturaShow}/>
      <ResourceGuesser name="pagos" />
      <ResourceGuesser name="servicios" />
  </HydraAdmin>
);



export default App;
