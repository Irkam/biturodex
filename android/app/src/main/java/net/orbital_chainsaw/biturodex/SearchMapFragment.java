package net.orbital_chainsaw.biturodex;

import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.google.android.gms.maps.MapFragment;

/**
 * Created by jivay on 24/09/14.
 */
public class SearchMapFragment extends Fragment {
    public SearchMapFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.fragment_search_map, container, false);
        getFragmentManager().beginTransaction().replace(R.id.search_map_container, new MapFragment(), "map").commit();
        return rootView;
    }
}
