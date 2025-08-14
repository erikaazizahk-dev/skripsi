from qgis.core import (
    QgsProject,
    QgsSpatialIndex,
    QgsFeature,
    QgsGeometry,
    QgsField,
    QgsVectorLayer,
    QgsFeatureRequest,
    QgsExpression,
    QgsExpressionContext,
    QgsExpressionContextUtils,
    edit
)
from qgis.PyQt.QtCore import QVariant

# Layers
points_layer = QgsProject.instance().mapLayersByName('Kriya')[0]
polygons_layer = QgsProject.instance().mapLayersByName('Desa')[0]

# Add fields for nearest neighbor ID and distance
if points_layer.fields().indexOf('nn_id') == -1:
    points_layer.dataProvider().addAttributes([QgsField('nn_id', QVariant.Int)])
if points_layer.fields().indexOf('nn_dist') == -1:
    points_layer.dataProvider().addAttributes([QgsField('nn_dist', QVariant.Double)])

points_layer.updateFields()

# Create spatial index for points
index = QgsSpatialIndex(points_layer.getFeatures())

# Dictionary to store nearest neighbor information
nn_dict = {}

# Iterate over each polygon
for polygon in polygons_layer.getFeatures():
    # Get points within the polygon
    request = QgsFeatureRequest().setFilterRect(polygon.geometry().boundingBox())
    points_in_polygon = [feat for feat in points_layer.getFeatures(request) if polygon.geometry().contains(feat.geometry())]

    if not points_in_polygon:
        continue

    # Spatial index for points within the polygon
    polygon_index = QgsSpatialIndex()
    for feat in points_in_polygon:
        polygon_index.insertFeature(feat)

    # Find nearest neighbors
    for point in points_in_polygon:
        nearest_ids = polygon_index.nearestNeighbor(point.geometry().asPoint(), 2)  # Get 2 nearest neighbors including itself
        nearest_ids.remove(point.id())  # Remove itself

        if nearest_ids:
            nearest_id = nearest_ids[0]
            nearest_point = next(points_layer.getFeatures(QgsFeatureRequest(nearest_id)))
            distance = point.geometry().distance(nearest_point.geometry())
            nn_dict[point.id()] = (nearest_id, distance)

# Update point layer with nearest neighbor information
with edit(points_layer):
    for point_id, (nn_id, nn_dist) in nn_dict.items():
        feature = points_layer.getFeature(point_id)
        feature['nn_id'] = nn_id
        feature['nn_dist'] = nn_dist
        points_layer.updateFeature(feature)

print("Nearest neighbor calculation completed.")

# Calculate the total distance and the number of points
total_distance = 0
num_points = len(nn_dict)

# Sum the nearest neighbor distances
for point_id, (nearest_id, distance) in nn_dict.items():
    total_distance += distance

# Calculate the average nearest neighbor distance
if num_points > 0:
    average_nn_distance = total_distance / num_points
    print(f"Average Nearest Neighbor Distance: {average_nn_distance}")
else:
    print("No points to calculate average distance.")
