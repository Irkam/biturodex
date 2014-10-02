from django.contrib.auth.models import User, Group
from rest_framework import viewsets
from biturodex.serializers import UserSerializer, EventSerializer, EstablishmentSerializer
from biturodex.models import Event, Establishment


class UserViewSet(viewsets.ModelViewSet):
    """
    API endpoint that allows users to be viewed or edited.
    """
    queryset = User.objects.all()
    serializer_class = UserSerializer

class EventViewSet(viewsets.ModelViewSet):
    """
    API endpoint that allows users to be viewed or edited.
    """
    queryset = Event.objects.all()
    serializer_class = EventSerializer

class EstablishmentViewSet(viewsets.ModelViewSet):
    """
    API endpoint that allows users to be viewed or edited.
    """
    queryset = Establishment.objects.all()
    serializer_class = EstablishmentSerializer