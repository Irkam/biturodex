package net.orbital_chainsaw.biturodex;

import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;

/**
 * Created by jivay on 24/09/14.
 */
public class SearchMapFragment extends Fragment {
    private GoogleMap gmap;
    public SearchMapFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.fragment_search_map, container, false);
        MapFragment mapFragment = new MapFragment();
        gmap = mapFragment.getMap();

        getFragmentManager().beginTransaction()
                .replace(R.id.search_map_container, mapFragment, "map").commit();

        /*
        gmap.addMarker(new MarkerOptions()
                .position(new LatLng(43.230979,5.4396633))
                .title("Party Hard at Luminy"));
        gmap.moveCamera(CameraUpdateFactory.newLatLngZoom(new LatLng(43.230979,5.4396633), 14.0f));
        */

        return rootView;
    }
}
