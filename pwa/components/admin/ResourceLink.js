import React from 'react';
import { Link } from 'react-router-dom';

const ResourceLink = ({ resourceIdentifier, label = 'View' }) => {
  // Assuming resourceIdentifier is in the form "factura/1"
  const [resource, id] = resourceIdentifier.split('/');
  // If your routes are pluralized, adjust accordingly (e.g., "factura" -> "facturas")
  const route = `/${resource}s/${id}/show`;

  return <Link to={route}>{label}</Link>;
};

export default ResourceLink;
