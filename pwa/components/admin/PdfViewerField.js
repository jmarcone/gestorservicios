// src/PdfViewerField.js
import {React} from 'react';
import { Typography } from '@mui/material';
import { useRecordContext } from 'react-admin';

const PdfViewerField = ({ source}) => {
  const record = useRecordContext();

  const pdfUrl = record && record[source];

  if (!pdfUrl) {
    return <Typography variant="body2">No PDF available</Typography>;
  }

  return (
    <iframe
      src={pdfUrl}
      style={{ width: '100%', height: '600px', border: 'none' }}
      title="PDF Viewer"
    />
  );
};

export default PdfViewerField;
